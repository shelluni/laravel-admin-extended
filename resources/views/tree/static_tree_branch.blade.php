{
    text: "{!! $branchCallback($branch) !!}",
    @if($optionShowTags && array_has($branch, $keyName))
    tags: [
        "<a href='javascript:void(0);' data-id='{{ array_get($branch, $keyName) }}' class='tree_branch_delete'><i class='fa fa-trash'></i></a>",
        "<a href='{{ $path }}/{{ array_get($branch, $keyName) }}/edit'><i class='fa fa-edit'></i></a>"
    ],
    @endif
    selectable: {{ $optionNodeSelectable }},
    @if(isset($branch['children']))
    nodes: [
        @foreach($branch['children'] as $branch)
            @include($branchView, $branch)
        @endforeach

    ]
    @endif
},