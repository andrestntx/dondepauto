<legend class="h4" style="padding-top: 10px;">Datos de la Empresa</legend>
<div class="col-md-6">
    {!! Field::text('company') !!}
</div>
<div class="col-md-6">
    {!! Field::text('company_nit') !!}
</div>
<div class="col-md-6">
    {!! Field::text('company_role') !!}
</div>
<div class="col-md-6">
    {!! Field::text('company_area') !!}
</div>
<div class="col-md-6">
    {!! Field::select('city_id', $cities, ['empty' => 'Seleccione la ciudad']) !!}
</div>
<div class="col-md-6">
    {!! Field::text('address') !!}
</div>