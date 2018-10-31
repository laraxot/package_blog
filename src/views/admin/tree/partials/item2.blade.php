<li class="category_li" id="list_{{ $row->post_id }}">
	<div category_id="{{ $row->post_id }}" class="category_div enabled">
		<div class="category_row">
			<i class="handle fa-2x fa fa-arrows ico-droppable" ></i>
			<i class="toggle fa fa-chevron-right ico-childrens"></i>
			<span class="panel-title">{{ $row->post_id }}] {{ $row->title }}</span> 
			<div class="pull-right" style="padding-left: 10px;">
				<span  class="btn tooltips btn-white btn-xs category-enable">figli: {{ $row->sons()->count() }} </span>
				 
				{!! Form::bsBtnCrud(['id_post'=>$row->id,'class'=>'btn-xs']) !!}
				{!! Form::bsBtnCreate(['id_post'=>$row->id,'class'=>'btn-xs','txt'=>'inside','params'=>['parent_id'=>$row->post_id]]) !!}
				{!! Form::bsBtnCreate(['id_post'=>$row->id,'class'=>'btn-xs','txt'=>'after','params'=>['parent_id'=>$row->parent_id]]) !!}
				
			</div>
		</div>
		<div class="edit content_list_{{ $row->post_id }}"></div>
	</div>
	@foreach($row->sons()->get() as $row1)
		<ul style="display: none;" class="subcategory subcategories-{{ $row1->post_id }}">
		@include('blog::admin.post.tree.partials.item2',['row'=>$row1])
		</ul>
	@endforeach
</li>