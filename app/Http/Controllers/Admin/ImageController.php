<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\BaseController;
use App\Http\Requests\ImageRequest;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;


class ImageController extends BaseController
{

	const STORAGE_PATH = '/app/public/articles/';

	const PUBLIC_PATH = '/storage/articles/';


	public function store(ImageRequest $request)
	{
		$this->createDir( storage_path() . self::STORAGE_PATH );


		if( $request->hasFile('image') )
		{
			$file = $request->file('image');
			$fileName = time() . random_int(1, 10000) . '.' . $file->extension();

			Image::make($file->path())
				->widen(800, function ($constraint) {
					$constraint->upsize();
				})->save(storage_path() . self::STORAGE_PATH . $fileName);

			return response()->json(['filePath' => self::PUBLIC_PATH . $fileName]);
		}
		else
		{
			return response()->json(['error' => 'Obrázok nedorazil na server.']);
		}

	}


	private function createDir($path)
	{
		if( !is_dir($path) ) File::makeDirectory($path, '0755', TRUE, TRUE);
	}

}
