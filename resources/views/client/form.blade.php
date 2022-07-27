
         <div class="col-xs-12 col-sm-12 col-md-6 mt-3">
            {{ Form::label( __('messages.company_name') ) }}
            {{ Form::text('nombre_compañia', $client->nombre_compañia, ['class' => 'form-control' . ($errors->has('nombre_compañia') ? ' is-invalid' : ''), 'placeholder' =>  __('messages.company_name') ]) }}
            {!! $errors->first('nombre_compañia', '<div class="invalid-feedback">:message</div>') !!}
        </div>

         <div class="col-xs-12 col-sm-12 col-md-6 mt-3">
            {{ Form::label('R.F.C.') }}
            {{ Form::text('rfc', $client->rfc, ['class' => 'form-control' . ($errors->has('rfc') ? ' is-invalid' : ''), 'placeholder' => 'rfc']) }}
            {!! $errors->first('rfc', '<div class="invalid-feedback">:message</div>') !!}
        </div>

         <div class="col-xs-12 col-sm-12 col-md-6 mt-3">
            {{ Form::label(__('messages.country')) }}
            <select id="pais" name="pais" class="form-control">
                @include('client.paises')
            </select>
        </div>

         <div class="col-xs-12 col-sm-12 col-md-6 mt-3">
         </div>

        <div class="col-xs-12 col-sm-12 col-md-6 mt-3">
            {{ Form::label(__('messages.contact_name')) }}
            {{ Form::text('nombre', $client->nombre, ['class' => 'form-control' . ($errors->has('nombre') ? ' is-invalid' : ''), 'placeholder' => __('messages.contact_name')]) }}
            {!! $errors->first('nombre', '<div class="invalid-feedback">:message</div>') !!}
        </div>

         <div class="col-xs-12 col-sm-12 col-md-6 mt-3">
            {{ Form::label(__('messages.short_name')) }}
            {{ Form::text('nombre_corto', $client->nombre_corto, ['class' => 'form-control' . ($errors->has('nombre_corto') ? ' is-invalid' : ''), 'placeholder' => __('messages.short_name')]) }}
            {!! $errors->first('nombre_corto', '<div class="invalid-feedback">:message</div>') !!}
        </div>

        <div class="col-xs-12 col-sm-12 col-md-6 mt-3">
            {{ Form::label(__('messages.position')) }}
            {{ Form::text('posicion', $client->posicion, ['class' => 'form-control' . ($errors->has('posicion') ? ' is-invalid' : ''), 'placeholder' => __('messages.position')]) }}
            {!! $errors->first('posicion', '<div class="invalid-feedback">:message</div>') !!}
        </div>

        <div class="col-xs-12 col-sm-12 col-md-6 mt-3">
            {{ Form::label(__('messages.email')) }}
            {{ Form::email('email', $client->email, ['class' => 'form-control' . ($errors->has('email') ? ' is-invalid' : ''), 'placeholder' => __('messages.email')]) }}
            {!! $errors->first('email', '<div class="invalid-feedback">:message</div>') !!}
        </div>

         <div class="col-xs-12 col-sm-12 col-md-6 mt-3">
            {{ Form::label(__('messages.website')) }}
            {{ Form::text('pagina_web', $client->pagina_web, ['class' => 'form-control' . ($errors->has('pagina_web') ? ' is-invalid' : ''), 'placeholder' => __('messages.website')]) }}
            {!! $errors->first('pagina_web', '<div class="invalid-feedback">:message</div>') !!}
        </div>

        <div class="col-xs-12 col-sm-12 col-md-6 mt-3">
            {{ Form::label(__('messages.note')) }}
            {{ Form::text('notas', $client->notas, ['class' => 'form-control' . ($errors->has('notas') ? ' is-invalid' : ''), 'placeholder' => __('messages.note')]) }}
            {!! $errors->first('notas', '<div class="invalid-feedback">:message</div>') !!}
        </div>



        <div class="col-xs-12 col-sm-12 col-md-12 text-center mt-5">
           <button type="submit" class="btn" style="background: {{$configuracion->color_boton_save}}; color: #ffff">{{ __('messages.save') }}</button>
        </div>

