<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 2/15/2018
 * Time: 11:38 AM
 */

class displayTable
{

	public function __construct()
	{


	}


	public function openTableStripes()
	{
		echo '<table class="table table-bordered table-striped">';

		return $this;
	}
	public function openTable()
	{
		echo '<table class="table table-bordered">';

		return $this;
	}

	public function closeTable()
	{
		echo '</table>';

		return $this;

	}

	public function tHeadStart()
	{
		echo '<thead>';

		return $this;

	}

	public function tHeadEnd()
	{
		echo '</thead>';

		return $this;

	}

	public function tBodyStart()
	{
		echo '<tbody>';

		return $this;

	}

	public function tBodyEnd()
	{
		echo '</tbody>';

		return $this;

	}

	public function rowStart()
	{
		echo '<tr>';

		return $this;
	}

	public function rowEnd()
	{
		echo '</tr>';

		return $this;

	}

	public function tdVal($td)
	{
		echo '<td>' . $td . '</td>';

		return $this;

	}
	public function tdValBold($td)
	{
		echo '<td><b>' . $td . '</b></td>';

		return $this;

	}
	public function tdCustom($td, $tdCol)
	{
		echo '<td class="col-md-'.$tdCol.'">' . $td . '</td>';

		return $this;

	}

	public function thVal($th)
	{
		echo '<th>' . $th . '</th>';

		return $this;
		
	}
	
	public function startBootStrap()
	{
		echo '<div class = "container">';
		return $this;
	}
	public function endBootStrap()
	{
		echo '</div>';
		return $this;
	}
	
	
}
