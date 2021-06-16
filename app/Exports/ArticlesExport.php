<?php

namespace App\Exports;


use App\Models\Entities\Article;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;


class ArticlesExport implements
		WithColumnFormatting,
		FromCollection,
		WithStrictNullComparison,
		WithMapping,
		ShouldAutoSize
{

	/**
	* @return \Illuminate\Support\Collection
	*/
	public function collection()
	{
		return Article::orderBy('id', 'DESC')->get();
	}


	public function map($article): array
	{
		return [
			$article->id,
			$article->title,
			$article->user->name,
			$article->user->roles->map(function ($item) { return $item->name; })->join(', '),

			Date::dateTimeToExcel($article->created_at),

			($article->updated_at ? Date::dateTimeToExcel($article->updated_at) : NULL),
		];
	}


	/**
	 * @return array
	 */
	public function columnFormats(): array
	{
		return [
			'D' => NumberFormat::FORMAT_DATE_DDMMYYYY,
			'E' => NumberFormat::FORMAT_DATE_DDMMYYYY,
		];
	}
}
