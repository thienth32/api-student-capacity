<?php

namespace App\Console\Commands;

use App\Models\Enterprise;
use App\Models\Post;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SyncEnterpriseInfo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:enterprise {--dry-run}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync data (contact name, contact email, contact phone, tax number) from post to enterprises';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $recruitmentPosts = Post::where('postable_type', \App\Models\Recruitment::class)->get();
        $enterprises = Enterprise::all();
        $count = 0;

        try {
            DB::beginTransaction();
            foreach ($enterprises as $e) {
                $isUpdate = false;
                $recruitmentPost = $recruitmentPosts->last(function ($item) use ($e) {
                    return $item->enterprise_id === $e->id;
                });
                
                $oldTaxNumber = $e->tax_number;
                $oldContactName = $e->contact_name;
                $oldContactPhone = $e->contact_phone;
                $oldContactEmail = $e->contact_email;

                if ($recruitmentPost) {
                    $this->info(PHP_EOL."===> Start sync for $e->name");

                    if ($recruitmentPost->tax_number != $oldTaxNumber && $recruitmentPost->tax_number != null) {
                        $e->update(['tax_number' => $recruitmentPost->tax_number]);
                        $isUpdate = true;
                        $this->info(PHP_EOL." ------------ Synced tax number from $oldTaxNumber to $recruitmentPost->tax_number");
                    }
                    if ($recruitmentPost->contact_name != $oldContactName && $recruitmentPost->contact_name != null) {
                        $e->update(['contact_name' => $recruitmentPost->contact_name]);
                        $isUpdate = true;
                        $this->info(PHP_EOL." ------------ Synced contact name from $oldContactName to $recruitmentPost->contact_name");
                    }
                    if ($recruitmentPost->contact_phone != $oldContactPhone && $recruitmentPost->contact_phone != null) {
                        $e->update(['contact_phone' => $recruitmentPost->contact_phone]);
                        $isUpdate = true;
                        $this->info(PHP_EOL." ------------ Synced contact phone from $oldContactPhone to $recruitmentPost->contact_phone");
                    }
                    if ($recruitmentPost->contact_email != $oldContactEmail && $recruitmentPost->contact_email != null) {
                        $e->update(['contact_email' => $recruitmentPost->contact_email]);
                        $isUpdate = true;
                        $this->info(PHP_EOL." ------------ Synced contact email from $oldContactEmail to $recruitmentPost->contact_email");
                    }
                    if ($isUpdate == true) {
                        $count += 1;
                        $this->info(PHP_EOL."===> Synced successfully for $e->name");
                    } else {
                        $this->info(PHP_EOL."===> There is no data to sync for $e->name");
                    }
                }
            }

            if ($this->option('dry-run')) {
                DB::rollBack();
            } else {
                DB::commit();
            }
            $this->info(PHP_EOL.'===> Sync success total '.$count.' enterprises');
        } catch (Exception $exception) {
            DB::rollBack();
            dump($exception);
        }
    }
}
