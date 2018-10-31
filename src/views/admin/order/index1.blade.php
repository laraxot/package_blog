@extends('adm_theme::layouts.app')
{{ Theme::add('blog::admin/post/order/css/style.css') }}
{{ Theme::add('theme/bc/jquery/dist/jquery.min.js') }}
{{ Theme::add('theme/bc/Nestable/jquery.nestable.js') }}
@push('scripts')
<script>
    $(document).ready(function()
    {
    
        var updateOutput = function(e)
        {
            var list   = e.length ? e : $(e.target),
                output = list.data('output');
            if (window.JSON) {
                output.val(window.JSON.stringify(list.nestable('serialize')));//, null, 2));
            } else {
                output.val('JSON browser support required for this demo.');
            }
        };
        
        // activate Nestable for list 1
        $('#nestable').nestable({
            group: 1
        }).on('change', updateOutput);

        
        // activate Nestable for list 2
        $('#nestable2').nestable({
            group: 1
        }).on('change', updateOutput);
        
        // output initial serialised data
        updateOutput($('#nestable').data('output', $('#nestable-output')));
        updateOutput($('#nestable2').data('output', $('#nestable2-output')));
    
        $('#nestable-menu').on('click', function(e)
        {
            var target = $(e.target),
                action = target.data('action');
            if (action === 'expand-all') {
                $('.dd').nestable('expandAll');
            }
            if (action === 'collapse-all') {
                $('.dd').nestable('collapseAll');
            }
        });
    
        $('#nestable3').nestable();
    
    });
</script>
@endpush
@section('content')
@include('backend::includes.flash')
@include('backend::includes.components')
<p><strong>PLEASE NOTE: I cannot provide any support or guidance beyond this README. If this code helps you that's great but I have no plans to develop Nestable beyond this demo (it's not a final product and has limited functionality). I cannot reply to any requests for help.</strong></p>
<menu id="nestable-menu">
    <button type="button" data-action="expand-all">Expand All</button>
    <button type="button" data-action="collapse-all">Collapse All</button>
</menu>

<div class="cf nestable-lists">
    <div class="dd" id="nestable">
        <ol class="dd-list">
            @foreach($allrows->ofParent(0)->get() as $row)
            @include('blog::admin.post.order.partials.item1',['row'=>$row])
            @endforeach
        </ol>
    </div>
    {{--
    <div class="dd" id="nestable2">
        <ol class="dd-list">
            <li class="dd-item" data-id="13">
                <div class="dd-handle">Item 13</div>
            </li>
            <li class="dd-item" data-id="14">
                <div class="dd-handle">Item 14</div>
            </li>
            <li class="dd-item" data-id="15">
                <div class="dd-handle">Item 15</div>
                <ol class="dd-list">
                    <li class="dd-item" data-id="16">
                        <div class="dd-handle">Item 16</div>
                    </li>
                    <li class="dd-item" data-id="17">
                        <div class="dd-handle">Item 17</div>
                    </li>
                    <li class="dd-item" data-id="18">
                        <div class="dd-handle">Item 18</div>
                    </li>
                </ol>
            </li>
        </ol>
    </div>
    --}}
</div>
{{--
<p><strong>Serialised Output (per list)</strong></p>
<textarea id="nestable-output"></textarea>
<textarea id="nestable2-output"></textarea>
<p>&nbsp;</p>
<div class="cf nestable-lists">
    <p><strong>Draggable Handles</strong></p>
    <p>If you're clever with your CSS and markup this can be achieved without any JavaScript changes.</p>
    <div class="dd" id="nestable3">
        <ol class="dd-list">
            <li class="dd-item dd3-item" data-id="13">
                <div class="dd-handle dd3-handle">Drag</div>
                <div class="dd3-content">Item 13</div>
            </li>
            <li class="dd-item dd3-item" data-id="14">
                <div class="dd-handle dd3-handle">Drag</div>
                <div class="dd3-content">Item 14</div>
            </li>
            <li class="dd-item dd3-item" data-id="15">
                <div class="dd-handle dd3-handle">Drag</div>
                <div class="dd3-content">Item 15</div>
                <ol class="dd-list">
                    <li class="dd-item dd3-item" data-id="16">
                        <div class="dd-handle dd3-handle">Drag</div>
                        <div class="dd3-content">Item 16</div>
                    </li>
                    <li class="dd-item dd3-item" data-id="17">
                        <div class="dd-handle dd3-handle">Drag</div>
                        <div class="dd3-content">Item 17</div>
                    </li>
                    <li class="dd-item dd3-item" data-id="18">
                        <div class="dd-handle dd3-handle">Drag</div>
                        <div class="dd3-content">Item 18<a href="" style="float:right;">ee</a> </div>
                    </li>
                </ol>
            </li>
        </ol>
    </div>
</div>
--}}
@endsection