<?php defined('SYSPATH') or die('No direct script access.');

class Layers_Controller extends Main_Controller {

	function is_ajax(){
		return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND 
          strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest');
	}
	
	public function update($id = false,$name,$color){
		$layer = ORM::factory("location_layer")->where('id',$id)->find();
		
		$layer->layer_name = $name;
		$layer->layer_color = $color;
		$layer->save();
		
		$this->template->content = new View('layer_category_list');
		$this->template->footer = NULL;
		$this->template->header = new View("header_clean");
		$this->template->content->layers = ORM::factory('location_layer')->where("incident_id",$layer->incident_id)->find_all();
		$this->template->content->user = $this->user;
		$this->template->header->header_block = $this->themes->header_block();
	}
	
	public function edit($id = false){
		$this->template->header = new View('header_clean');
		$this->template->footer = NULL;	
		$this->template->content = new View('layers_edit');
		
		$layer = ORM::factory("location_layer")->where('id',$id)->find();
		$form = array
		(
			'layer_name' => $layer->layer_name,
			'layer_color' => $layer->layer_color,
		);

		$this->template->content->id = $layer->id;
		$this->template->content->form = $form;			
		$this->template->header->header_block = $this->themes->header_block();
	}

	public function destroy($id = false){
		$this->template->header = NULL;
		$this->template->footer = NULL;	
		$this->template->content = NULL;

		$layer = ORM::factory('location_layer')->where('id',$id)->find();
		$markers = ORM::factory('location')->where('layer_id',$id)->find_all();
		$incident_id = $layer->incident_id;
		$layer->delete();
		$new_layer = ORM::factory('location_layer')->where('incident_id',$incident_id)->find();
		foreach($markers as $marker){
			$marker->layer_id = $new_layer->id;
			$marker->save();
		}
	}
		
	public function create($id = false){
		$this->template->header = NULL;
		$this->template->footer = NULL;
		$this->template->content = new View('create_layer');
		
		$layer_count = ORM::factory('location_layer')->where('incident_id',$id)->find_all()->count();
		$layer = ORM::factory('location_layer');
		$colors = array("000033","edd115","6cd012","1181c2","ba11c2");
		
		$layer->layer_color = $colors[$layer_count % 5];
		
		$layer->layer_name = Kohana::lang('ui_main.layer_begin_name')." ".$layer_count;
		$layer->incident_id = $id;
		$layer->owner_id = $this->user->id;
		$layer->save();
		
		$this->template->content->layer_id = $layer->id;
		$this->template->content->layer_name = $layer->layer_name;
		$this->template->content->layer_color = $layer->layer_color;
	}
		
	public function remove_location($id = false){
		$this->template->header = NULL;
		$this->template->footer = NULL;
		$this->template->content = new View('location_ajax_js');
		if ($this->is_ajax()){
			$this->template->content->post = 1;
		} else {
			$this->template->content->post = 0;			
		}
	}
	
}