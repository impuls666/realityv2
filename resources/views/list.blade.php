<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<markers>
    @foreach ($markers as $marker)
        <marker id_reality="{{$marker->id}}" name="{{$marker->name}}" address="{{$marker->address}}" lat="{{$marker->lat}}" lng="{{$marker->lng}}" type="{{$marker->type}}" image="{{$marker->displayimage}}" size="{{$marker->size}}" price="{{$marker->price}}" kraj="{{$marker->kraj}}" mesto="{{$marker->mesto}}"/>
    @endforeach
</markers>