<?php

namespace App\Console\Commands;


use Illuminate\Console\Command;


class DeleteGeneratedFiles extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'delete:generated-files';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Delete generated files after deploy. Files with chmod 644 like session or cache.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return int
	 */
	public function handle()
	{
		$this->rrmdir(__DIR__ . '/../../../storage');
		$this->rrmdir(__DIR__ . '/../../../bootstrap');

		echo 'Directories storage and bootstrap should be deleted.';

		return 0;
	}


	protected function rrmdir($dir)
	{
		if ( is_dir($dir) )
		{
			$objects = scandir($dir);
			foreach ($objects as $object)
			{
				if ( $object != "." && $object != ".." )
				{
					if ( is_dir($dir. DIRECTORY_SEPARATOR .$object) && !is_link($dir."/".$object) )
					{
						$this->rrmdir($dir. DIRECTORY_SEPARATOR .$object);
					}
					else
					{
						unlink($dir. DIRECTORY_SEPARATOR .$object);
					}
				}
			}
			rmdir($dir);
		}
	}
}
