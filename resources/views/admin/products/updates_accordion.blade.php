<div class="accordion accordion-flush" id="accordionFlushExample">
@if(count($row->images->where('is_accept',0)) > 0)
<div class="accordion-item">
    <h2 class="accordion-header" id="flush-headingImages">
        <button class="accordion-button" type="button" data-bs-toggle="collapse"
            data-bs-target="#flush-collapseImages" aria-expanded="true" aria-controls="flush-collapseImages">
            @lang('admin.products.images')
        </button>
    </h2>
    <div id="flush-collapseImages" class="accordion-collapse collapse show" aria-labelledby="flush-headingOne"
        data-bs-parent="#accordionFlushExample">
        <div class="accordion-body">
            @foreach($row->images->where('is_accept',0) as $new_image)
            <img src="{{url($new_image->square_image)}}" style="height: 80px;border: 1px solid #eee;;">
            @endforeach
        </div>
    </div>
</div>
@endif
@foreach(json_decode($row->temp->updated_data,true) ?? [] as $key=>$fieldUpdated)
    @if(($key=='image') || 
        ($key=='image_from' && !$row->square_image_temp)  || 
        ($key=='clearance_cert' && !$row->clearance_cert_media_temp)  || 
        in_array($key,['price_before_offer_from','price_from','is_visible_from'])
        )
        @continue
    @endif
    <div class="accordion-item">
        <h2 class="accordion-header" id="flush-headingOne{{$key}}">
            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                data-bs-target="#flush-collapseOne{{$key}}" aria-expanded="true" aria-controls="flush-collapseOne">
                @lang('admin.'.$key)
            </button>
        </h2>
        <div id="flush-collapseOne{{$key}}" class="accordion-collapse collapse show" aria-labelledby="flush-headingOne"
            data-bs-parent="#accordionFlushExample">
            <div class="accordion-body">
                @lang('admin.products.field_changed') @lang('admin.'.$key)

                @if($key=='image_from')
                    @if($row->square_image_temp && $row->square_image_temp != $row->square_image)
                    @lang('admin.from')
                        <img src="{{ $row->square_image }}" style="max-width: 270px;">
                        @lang('admin.to')
                    <img src="{{ $row->square_image_temp }}" style="max-width: 270px;">
                    @endif
                @elseif($key=='clearance_cert')
                    @if($row->clearance_cert_media_temp && $row->clearance_cert_media_temp != $row->clearance_cert_media)
                        @lang('admin.from')
                        <a href="{{ $row->clearance_cert_media }}" class="btn btn-sm btn-info">عرض</a>
                        @lang('admin.to')
                        <a href="{{ $row->clearance_cert_media_temp }}" class="btn btn-sm btn-info">عرض</a>
                    @endif
                @else
                    @if($row->$key != $row->temp->$key || $key == "is_visible")
                        @if($key=='quantity_type_id')
                            @lang('admin.from')
                                {{$row->quantity_type?->name}}
                            @lang('admin.to')
                                {{$row->temp->quantity_type?->name}}
                        @elseif($key=='category_id')
                            @lang('admin.from')
                                {{$row->category?->name}}
                            @lang('admin.to')
                                {{$row->temp->category?->name}}
                        @elseif($key=='sub_category_id')
                            @lang('admin.from')
                                {{$row->subCategory?->name}}
                            @lang('admin.to')
                                {{$row->temp->subCategory?->name}}
                        @elseif($key=='final_category_id')
                            @lang('admin.from')
                                {{$row->finalSubCategory?->name}}
                            @lang('admin.to')
                                {{$row->temp->finalSubCategory?->name}}
                        @elseif($key=='type_id')
                            @lang('admin.from')
                                {{$row->type?->name}}
                            @lang('admin.to')
                                {{$row->temp->type?->name}}
                        @elseif($key == "price")
                            @lang('admin.from')
                            {{ number_format(json_decode($row->temp?->updated_data,true)["price_from"] ?? 0 , 2) }} @lang("translation.sar")
                                @lang('admin.to')
                            {{ number_format(json_decode($row->temp?->updated_data,true)["price"] , 2) }} @lang("translation.sar")
                        @elseif($key == "price_before_offer")
                            @lang('admin.from')
                            {{ number_format(json_decode($row->temp?->updated_data,true)["price_before_offer_from"] ?? 0 , 2) }} @lang("translation.sar")
                            @lang('admin.to')
                            {{ number_format(json_decode($row->temp?->updated_data,true)["price_before_offer"] , 2) }} @lang("translation.sar")
                        @elseif($key == "is_visible")
                            @lang('admin.from')
                            {{ isset(json_decode($row->temp?->updated_data,true)["is_visible_from"]) && json_decode($row->temp?->updated_data,true)["is_visible_from"] ? 'مرئي' : 'مخفي' }} 
                            @lang('admin.to')
                            {{ isset(json_decode($row->temp?->updated_data,true)["is_visible"]) && json_decode($row->temp?->updated_data,true)["is_visible"] ? 'مرئي' : 'مخفي' }}
                        @else
                            @lang('admin.from')
                                {{$row->$key}}
                            @lang('admin.to')
                                {{$fieldUpdated}}
                        @endif
                    @endif
                    
                    @foreach(Config::get('app.locales') as $locale)
                        <!-- translated name -->
                        @if($key=='name_'.$locale && $row->getTranslation('name',$locale) != $row->temp->getTranslation('name',$locale))
                            @lang('admin.from')
                            {{$row->getTranslation('name',$locale)}}
                            @lang('admin.to')
                            {{$row->temp->getTranslation('name',$locale)}}
                        @endif
                         <!-- translated desc -->
                        @if($key=='desc_'.$locale && $row->getTranslation('desc',$locale) != $row->temp->getTranslation('desc',$locale))
                            @lang('admin.from')
                            {!!$row->getTranslation('desc',$locale)!!}
                            @lang('admin.to')
                            {!!$row->temp->getTranslation('desc',$locale)!!}
                        @endif
                    @endforeach
                    
                @endif
            </div>
        </div>
    </div>
@endforeach

</div>