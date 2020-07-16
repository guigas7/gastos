{{-- Campo Nome --}}
<div class="row mb0">
  <div class="input-field col s12{{ $errors->has('nome') ? ' mb25' : '' }}">
    <input id="nome" type="text" name="nome" class="validate no-valid{{ $errors->has('nome') ? ' invalid' : '' }}" value="{{ isset($parceiro) ? old('nome', $parceiro->nome) : old('nome') }}" data-length="255" maxlength="255" required>
    <label for="nome">{{ __('Nome') }}</label>
    @if ($errors->has('nome'))
      <span class="helper-text" data-error="{{ $errors->first('nome') }}"></span>
    @endif
  </div>
</div>
{{-- Fim campo Nome --}}

{{-- Campo Descricao --}}
<div class="row mb0">
  <div class="input-field col s12{{ $errors->has('descricao') ? ' mb25' : '' }}">
    <textarea id="descricao" name="descricao" class="materialize-textarea validate no-valid{{ $errors->has('descricao') ? ' invalid' : '' }}" data-length="500" maxlength="500">{{ isset($parceiro) ? old('descricao', $parceiro->descricao) : old('descricao') }}</textarea>
    <label for="descricao">{{ __('Descrição') }}</label>
    @if ($errors->has('descricao'))
      <span class="helper-text" data-error="{{ $errors->first('descricao') }}"></span>
    @endif
  </div>
</div>
{{-- Fim campo Descricao --}}


{{-- Campo Link --}}
<div class="row mb0">
  <div class="input-field col s12{{ $errors->has('link') ? ' mb25' : '' }}">
    <input id="link" type="text" name="link" class="validate no-valid{{ $errors->has('link') ? ' invalid' : '' }}" value="{{ isset($parceiro) ? old('link', $parceiro->link) : old('link') }}" data-length="255" maxlength="255">
    <label for="link">{{ __('Link') }}</label>
    @if ($errors->has('link'))
      <span class="helper-text" data-error="{{ $errors->first('link') }}"></span>
    @endif
  </div>
</div>
{{-- Fim campo Link --}}

<!-- Submit Field -->
<div class="d-flex space-between">
  <a class="btn-flat waves-effect light-blue-text text-lighten-2" href="{!! route('parceiros.index') !!}">{{ __('Cancelar') }}</a>
  <button type="submit" class="btn waves-effect waves-light">{{ __('Salvar') }}</button>
</div>
