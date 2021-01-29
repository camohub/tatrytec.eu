<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\BaseController;


class GaleryController extends BaseController
{

	/** @var  App\Model\Entities\Images */
	public $images;



	public function renderDefault()
	{
		$images = $this->images->imagesResultSet( [ 'module.id =' => 1 ] );
		$this->template->images = $this->setPaginator( $images );
		$this->template->page = $this['vp']->getPaginator()->page;

	}


///////Protected/////////////////////////////////////////////////////////////


	protected function setPaginator( $images )
	{
		$vp = $this['vp'];
		$paginator = $vp->getPaginator();
		$paginator->itemsPerPage = 3;

		$images->applyPaginator( $paginator );

		return $images;

	}


}
