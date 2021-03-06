export default [
@foreach($menus as $menu)
{
path: '{{ $menu["path"] }}',
name: '{{ $menu["name"] }}',
component: @if(!isset($menu['component'])){
render(c) {
return c('router-view')
}
}, @elseif(isset($menu['component']))
component: httpVueLoader('{!! $menu['component'] !!}'),
@endif
@if(isset($menu["children"]))
children: [
@foreach($menu["children"] as $child)
{
path: '{{ $child["path"] }}',
name: '{{ $child["name"] }}',
component: httpVueLoader('{!! $child['component'] !!}')
},
@endforeach
]
@endif
},
@endforeach
]
