
<template>
    <div class="container">
        <div class="row justify-content-center">



            <div class="col-md-12">
                <div class="card card-default">
                    <div class="card-header">Import CSV</div>

                    <div class="card-body uploadcsv" v-if="finish == 1">

                            <div class="alert alert-success">
                                <h3>Obrigado, recebemos seu arquivo e já estamos importando \o/</h3>
                                <p>Você será nofificado quando o processo de importação for concluído</p>
                            </div>

                    </div>
                    <div class="card-body uploadcsv" v-if="finish == 0">

                        <div class="form-group">
                          <label for="csv_file" class="control-label col-sm-3 text-right">CSV file to import</label>
                          <div class="col-sm-9">

                              <input type="file" id="file" ref="file" class="form-control" v-on:change="loadCSV($event)"/>
                              <input type="checkbox" v-model="has_header"> Arquivo Possui Cabeçalho ?

                              <div class="progress" v-if="uploadPercentage > 1 && uploadPercentage < 100 ">
                                  <div class="progress-bar" role="progressbar" v-bind:style="{width: uploadPercentage + '%'}" :aria-valuenow="uploadPercentage" aria-valuemin="0" aria-valuemax="100"></div>
                              </div>

                          </div>
                        </div>

                        <div v-if="headers" class="alert alert-info">
                            <h4>Essa é uma amostra do seu arquivo, mapeie as colunas nas opções abaixo.</h4>
                        </div>



                        <div v-if="headers" class="table-responsive">

                            <table  class="table table-bordered">
                                <th v-for="header in headers" >{{header}}</th>
                                <tr v-for="line in lines">
                                    <td v-for="item in line" class="wrap">{{item}}</td>
                                </tr>
                                <th v-for="(header, index) in headers">
                                    <select v-model="fieldName[index]" @change="removeItem($event)" class="fieldMap">
                                        <option v-for="optionItem in options" :value="optionItem.key">{{optionItem.label}}</option>
                                    </select>
                                </th>
                            </table>
                            <button class="btn btn-primary" @click="sendMap()" :disabled="uploadPercentage < 100">Importar</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        

            mounted () {

            },
            data() {

                return {
                    file:null,
                    info:null,
                    fileserver:null,
                    fieldName:[],                    
                    lines:null,
                    has_header: true,
                    headers:null,
                    finish:0,
                    uploadPercentage:0,
                    options:[
                        {key:'',label: 'Não importar'},
                        {key:'id',label: 'Identificador'},
                        {key:'name',label: 'Nome'},
                        {key:'email',label: 'Email'},
                        {key:'document',label: 'CPF/CNPJ'},
                        {key:'employee',label: 'Empresa'},
                        {key:'occupation',label: 'Profissão'},
                        {key:'phone',label: 'Fone'},
                        {key:'city',label: 'Cidade'},
                        {key:'state',label: 'Estado'},
                        {key:'country',label: 'País'},
                        {key:'status',label: 'Status do lead'},
                        {key:'stage',label: 'Estágio do Funil'},
                        {key:'deal_title',label: 'Título do Negócio'},
                        {key:'deal_value',label: 'Valor do Negócio'},
                        {key:'conversion_count',label: 'Total Conversões'},
                        {key:'last_conversion',label: 'Última Conversão'},
                        {key:'domain',label: 'Domínio'},
                        {key:'url',label: 'URL'},
                    ]
                }
        },
        filters: {
            capitalize: function (str) {
                return str.charAt(0).toUpperCase() + str.slice(1)
            }
        },
        methods: {
            hasItem: function(item, value)
            {

                if (Object.values(item).indexOf(value) > -1) {
                    return true;
                }else{
                    return false
                }
            },
            removeItem: function (e) {

                if (!jQuery.inArray(e.target.value, this.fieldName) && this.fieldName.length>1)
                {
                    // TODO deny item duplicated                    
                }
                return true;
            },
            sendMap:function()
            {
                var vm = this;
                if (!this.hasItem(this.fieldName, 'email'))
                {
                    alert('Você deve selecionar o campo e-mail');
                    return false;

                }else {

                    if (this.fieldName.length < this.options.length) {
                        if (confirm('você não mapeou todos os campos, campos não mapeado serão ignorados,' +
                            ' Você tem certeza que deseja continuar?'))
                        {
                            axios.post('/savemap',{'id': vm.file.id ,'mapping':vm.fieldName},
                                {
                                    headers: {                                    
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    }
                                }).then(function(response){
                                        vm.finish=1;
                                });                            
                        }
                    }
                }
            },

            submitFile(){
                var vm = this;
                let formData = new FormData();
                formData.append('fileimport', this.file);
                formData.append('has_header', this.has_header);

                axios.post( '/upload',formData,
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data',
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        onUploadProgress: function( progressEvent ) {
                            this.uploadPercentage = parseInt( Math.round((progressEvent.loaded * 100 ) / progressEvent.total ) );
                        }.bind(this)
                    }).then(function(response){
                        vm.file = response.data;
                    })
                    .catch(function(){
                        console.log('FAILURE!!');
                    });
            },
            loadCSV(e) {
                var vm = this;
                vm.file = this.$refs.file.files[0];
                vm.submitFile();

                if (window.FileReader) {
                    var reader = new FileReader();
                    if(e.target.files[0].type!="text/csv"){
                        alert('tipo de arquivo não suportado, envie um arquivo CSV');
                        return;
                    }
                    reader.readAsText(e.target.files[0]);

                    reader.onload = function(event) {
                        var csv = event.target.result;
                        vm.parse_csv = vm.processData(csv)



                    };
                    reader.onerror = function(evt) {
                        if(evt.target.error.name == "NotReadableError") {
                            alert("Canno't read file !");
                        }
                    };
                } else {
                    alert('FileReader are not supported in this browser.');
                }
            },
            processData:function(allText) {

                var allTextLines = allText.split(/\r\n|\n/);

                var headers = allTextLines[0].split(';');
                var lines = [];

                for (var i=1; i<=3; i++) {
                    var data = allTextLines[i].split(';');
                    if (data.length == headers.length) {

                        var tarr = [];
                        for (var j=0; j<headers.length; j++) {
                            tarr.push(data[j].replace(/"([^"]+(?="))"/g, '$1'));
                        }
                        lines.push(tarr);
                    }
                }
                this.lines = lines;
                this.headers = headers;
            }
        }
    }
    
</script>


<style>
    .table th, .table td{
        padding: 0.25em !important;
    }
    .wrap{
        white-space: nowrap; text-overflow:ellipsis; overflow: hidden; max-width:1px;
    }
</style>