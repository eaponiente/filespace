<?php

use App\Models\Filenas;
use Illuminate\Database\Seeder;

class FilenasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	Filenas::truncate();

        DB::statement("
        	INSERT INTO `chs_filenas` (`id`, `serverLabel`, `serverType`, `ipAddress`, `ftpPort`, `ftpUsername`, `ftpPassword`, `sftpHost`, `sftpPort`, `sftpUsername`, `sftpPassword`, `statusId`, `storagePath`, `fileServerDomainName`, `scriptPath`, `files`, `space_used`, `total_space`) VALUES
				(1, 'Local Default', 'local', '', 0, '', '', '', 22, '', '', 2, 'uploads/', '', '', 4102, 4006967971598, 0),
				(2, 'Yeti Test Server', 'direct', '162.243.198.194', 21, 'yeti', 'SDPsk9Fmr5rDREXU', '', 22, '', '', 2, 'remote_uploads/', 'http://fs.filespace.io', 'do-upload', 957, 1100492941084, 0);");
    }
}
