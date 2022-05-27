<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');


if (!function_exists('createParentTree')) {
    function createParentTree($data, $parrent, $id, $module) {
		$str = '';
		if(isset($data[$parrent])){ 
			
			foreach($data[$parrent] as $value){
				$idStr = $id .'.'. $value['UnitId'];
				$child = createParentTree($data, $value['UnitId'], $idStr, $module);
				if( $child ){					
					$str .= '<tr data-tt-id="'. $idStr .'" data-tt-parent-id="'. $id .'">
								<td>'. $value['UnitKode'] .'</td>
								<td>'. $value['UnitName'] .'</td>
								<td>
									<div class="hidden-sm hidden-xs btn-group">
										<a href="'. site_url($module . '/update/' .  $value['UnitId']) .'" data-original-title="Edit data '. $value['UnitKode'] .'" data-rel="tooltip" data-placement="bottom">
										<button class="btn btn-xs btn-info">
											<i class="ace-icon fa fa-pencil bigger-120"></i>
										</button>
										</a>
									</div>

									<div class="hidden-md hidden-lg">
										<div class="inline pos-rel">
											<button class="btn btn-minier btn-primary dropdown-toggle" data-toggle="dropdown" data-position="auto">
												<i class="ace-icon fa fa-cog icon-only bigger-110"></i>
											</button>

											<ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
												<li>
													<a href="'. site_url($module . '/update/' .  $value['UnitId']) .'" class="tooltip-info" data-original-title="Edit data '. $value['UnitKode'] .'" data-rel="tooltip" data-placement="bottom">
														<span class="blue">
															<i class="ace-icon fa fa-pencil-square-o bigger-120"></i>
														</span>
													</a>
												</li>
											</ul>
										</div>
									</div>
								</td>
							  </tr>'. $child;
				} else {
					$str .= '<tr data-tt-id="'. $idStr .'"  data-tt-parent-id="'. $id .'">
								<td>'. $value['UnitKode'] .'</td>
								<td>'. $value['UnitName'] .'</td>
								<td>
									<div class="hidden-sm hidden-xs btn-group">
										<a href="'. site_url($module . '/update/' .  $value['UnitId']) .'" data-original-title="Edit data '. $value['UnitKode'] .'" data-rel="tooltip" data-placement="bottom">
										<button class="btn btn-xs btn-info">
											<i class="ace-icon fa fa-pencil bigger-120"></i>
										</button>
										</a>
										<a id="delete-btn" href="'. site_url($module . '/delete/' .  $value['UnitId']) .'" class="tooltip-info" data-original-title="Delete data '. $value['UnitKode'] .'" data-rel="tooltip" data-placement="bottom">
											<button class="btn btn-xs btn-danger">
												<i class="ace-icon fa fa-trash-o bigger-120"></i>
											</button>
										</a>
									</div>

									<div class="hidden-md hidden-lg">
										<div class="inline pos-rel">
											<button class="btn btn-minier btn-primary dropdown-toggle" data-toggle="dropdown" data-position="auto">
												<i class="ace-icon fa fa-cog icon-only bigger-110"></i>
											</button>

											<ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
												<li>
													<a href="'. site_url($module . '/update/' .  $value['UnitId']) .'" class="tooltip-info" data-original-title="Edit data '. $value['UnitKode'] .'" data-rel="tooltip" data-placement="bottom">
														<span class="blue">
															<i class="ace-icon fa fa-pencil-square-o bigger-120"></i>
														</span>
													</a>
												</li>
												<li>
													<a id="delete-btn" href="'. site_url($module . '/delete/' .  $value['UnitId']) .'" class="tooltip-info" data-original-title="Delete data '. $value['UnitKode'] .'" data-rel="tooltip" data-placement="bottom">
														<span class="red">
															<i class="ace-icon fa fa-trash-o bigger-120"></i>
														</span>
													</a>
												</li>
											</ul>
										</div>
									</div>
								</td>
							  </tr>';
				}
			}
		}
		
		return $str;
    }
}