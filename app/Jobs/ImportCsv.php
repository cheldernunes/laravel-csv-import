<?php

namespace Csvimport\Jobs;

use Csvimport\Import;
use Csvimport\Lead;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Storage;
use Csvimport\Events\ImportFinished;
use Excel;


class ImportCsv implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    protected $fileimport;

    protected $timeout = 900;

    /**
     * Create a new job instance.
     *
     * @return void
     *
     */
    public function __construct(Import $fileimport )
    {
        $this->fileimport = $fileimport;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $import = $this->fileimport;

        Excel::load(Storage::path($this->fileimport->filename))
            ->chunk(200, function($data) use($import) {

                $mapping = json_decode($import->mapping);
                foreach ($data as $row) {

                    $item = [];
                    $i=0;
                    foreach (array_values($row->toArray()) as $k=>$v){
                        if (isset($mapping[$i]) && !is_null($mapping[$i]))
                        {
                            $item = array_merge($item,[$mapping[$i]=>$v]);
                        }
                        $i++;

                    }

                    Lead::updateOrCreate(['email'=>$item['email']], $item);
                }

                $import->status = 'processed';
                $import->save();
                event(new ImportFinished());
        });


    }
}
