<template>
    <table>
        <th v-for="header in headers" >{{header}}</th>
    </table>
</template>


<script>
    export default {
        data() {
            return {
                headers:[]
            }
        }
    }
</script>