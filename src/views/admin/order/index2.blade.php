@extends('adm_theme::layouts.app')
{{-- view-source:http://webbakerlab.com/nestedsortable/  --}}
{{ Theme::add("theme/bc/jquery/dist/jquery.min.js") }}
{{ Theme::add("theme/bc/jquery-ui/jquery-ui.min.js") }}
{{ Theme::add("theme/bc/jqueryui-touch-punch/jquery.ui.touch-punch.min.js") }}
{{ Theme::add("theme/bc/bootstrap/dist/js/bootstrap.min.js") }}
{{-- Theme::add("theme/bc/js/bootstrap-fileupload.js") --}} {{-- http://www.jasny.net/bootstrap/ --}}
{{ Theme::add("theme/bc/nestedSortable/jquery.mjs.nestedSortable.js") }}
{{-- Theme::add("theme/bc/js/file-validator.js") --}}
{{ Theme::add("blog::admin/post/order/css/style2.css") }}
{{ Theme::add("blog::admin/post/order/js/custom2.js") }}
@push('scripts')
<!--common script for all pages-->
<script type="text/javascript" charset="utf-8"></script>
@endpush
@section('content')
<header class="panel-heading">
	<h3>
		Category Management  
		<div class="btn-group">
			<a href="index.php?action=add_category" class="btn btn-success center-button" title="Add Post" role="button"><i class="fa fa-plus"></i> Add Category</a>
			<a href="preview.php" class="btn btn-primary center-button" title="Add Post" role="button"><i class="fa fa-eye"></i> Preview</a>
		</div>
	</h3>
</header>
<div class="panel-body category-container">
	<div class="alert alert-block alert-danger fade in" style="display: none;"></div>
	<div class="list-categories">
		<ul class="sortable" id='category-sortable'>
			@foreach($allrows->ofParent(0)->get() as $row)
            @include('blog::admin.post.order.partials.item2',['row'=>$row])
            @endforeach
		</ul>
	</div>
</div>

<!--main content end-->
<!-- Modal -->
<div class="modal fade" id="dialog-delete-category" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-category-id='' aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Delete Category ?</h4>
			</div>
			<div class="modal-body">
				<strong>WARNING</strong>: This will also delete the listings under that category. This action cannot be undone. Are you sure you want to continue?<br/><br/>
				<strong>NOTE</strong>: This will delete the listings under that category. This will not delete from database just for demo.it will back once page refresh.
			</div>
			<div class="modal-footer">
				<button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
				<button class="btn btn-danger" type="button" data-category-id='' id="category-delete-submit">Confirm</button>
			</div>
		</div>
	</div>
</div>
<!-- modal -->
@endsection
