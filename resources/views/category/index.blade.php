{{ $category->name }} <br><br><br>

{{$category->parent?->name}}<br><br><br>
@foreach($category->children as $child)
    {{ $child->name }}<br>
    @foreach($child->articles as $article)
        {{ $article->title }}<br><br><br>
    @endforeach
@endforeach

<br><br>

recursive <br>

@foreach($parentCategories as $parentCategory)
    {{ $parentCategory->name }}<br>
@endforeach
