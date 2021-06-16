<?php

namespace App\Exports;


use App\Models\Entities\Article;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;


class ArticlesExport implements
		WithColumnFormatting,
		FromCollection,
		WithStrictNullComparison,
		WithMapping,
		ShouldAutoSize,
		WithHeadings,
		WithStyles
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
			'E' => NumberFormat::FORMAT_DATE_DDMMYYYY,
			'F' => NumberFormat::FORMAT_DATE_DDMMYYYY,
		];
	}


	public function headings(): array
	{
		return [
			'ID',
			'Title',
			'Autor',
			'Roles',
			'Created',
			'Updated',
		];
	}


	public function styles(Worksheet $sheet)
	{
		return [
			// Style the first row as bold text.
			1    => [
				'font' => ['bold' => true],
				'fill' => [
					'fillType' => Fill::FILL_SOLID,
					'startColor' => ['rgb' => 'ddddff'],
				]
			],

			// Styling a specific cell by coordinate.
			'D1' => [
				'fillType' => Fill::FILL_SOLID,
				'fill' => ['startColor' => ['rgb' => 'ffddff']]
			],

			// Styling an entire column.
			'C'  => [
				'font' => ['bold' => true],
				'fill' => [
					'fillType' => Fill::FILL_SOLID,
					'startColor' => ['rgb' => 'ddddff'],
				]
			],
		];
	}
}
