<?php

namespace App\Jobs;

use App\Models\Employee;
use App\Models\Upload;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessEmployeesCsv implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $upload;

    /**
     * Create a new job instance.
     */
    public function __construct(Upload $upload)
    {
        $this->upload = $upload;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // access the model in the queue for processing
        $filename = $this->upload->filename;

        $rows = [];
        $file = public_path('/files/') . $filename;
        $handle = fopen($file, 'r');
        if ($handle !== FALSE)
        {
            while (($row = fgetcsv($handle, 1000, ',')) !== FALSE)
            {
                $rows[] = $row;
            }

            fclose($handle);
        }

        $count = count($rows);
        if ($count)
        {
            for ($i=0; $i < $count; $i++) {
                if ($i == 0) continue;

                $username = strtolower(htmlspecialchars($rows[$i][2]) . '.' . htmlspecialchars($rows[$i][4]));
                $employee = [
                    'employee_id' => htmlspecialchars($rows[$i][0]),
                    'username' => htmlspecialchars($username),
                    'name_prefix' => htmlspecialchars($rows[$i][1]),
                    'first_name' => htmlspecialchars($rows[$i][2]),
                    'middle_name' => htmlspecialchars($rows[$i][3]),
                    'last_name' => htmlspecialchars($rows[$i][4]),
                    'gender' => htmlspecialchars($rows[$i][5]),
                    'email' => filter_var($rows[$i][6], FILTER_SANITIZE_EMAIL),
                    'date_of_birth' => filter_var($rows[$i][7]),
                    'time_of_birth' => htmlspecialchars($rows[$i][8]),
                    'age' => (float) $rows[$i][9],
                    'employment_date' => htmlspecialchars($rows[$i][10]),
                    'employment_duration' => (float) $rows[$i][11],
                    'phone_number' => htmlspecialchars($rows[$i][12]),
                    'location' => htmlspecialchars($rows[$i][13]),
                    'county' => htmlspecialchars($rows[$i][14]),
                    'city' => htmlspecialchars($rows[$i][15]),
                    'zip' => htmlspecialchars($rows[$i][16]),
                    'region' => htmlspecialchars($rows[$i][17])
                ];

                $output = array_filter($employee, function($val) {
                    return trim($val);
                });

                Employee::create($output);
            }
        }
    }
}
