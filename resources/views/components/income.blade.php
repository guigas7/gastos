@props([
	'slug'			=> 'erro',
	'name' 			=> 'erro',
	'id'			=> 'erro',
	'description' 	=> 'erro',
	'recordValue' 		=> 'erro',
	'recordId'			=> 'erro',
	'recordDescription'	=> 'erro',
])

<li class="list-group-item">
    <div class="row d.flex row my-2 justify-content-center">
        <div class="col-md-8">
            <a  title="{{ $description }}"
                href="#"
                class="type-title"
                v-b-modal.modal-{{ $id }}>
                {{ $name }}
            </a>

            <b-modal hide-footer id="modal-{{ $id }}" title="Editar {{ $name }}" v-cloak>
                <div>
                    <form method="POST"
                        action="{{ route('income.update', $slug) }}"
                        class="cent">
                        @csrf
                        @method('PUT')

                        <div class="form-group row py-3 justify-content-center">
                            <label for="income-name" class="col-form-label col-lg-3 offset-lg-1">Nome: </label>
                            <div class="col-lg-7">
                              <input type="string" class="form-control" name="income-name" required autofocus value="{{ $name }}">
                            </div>
                        </div>
                        <hr>

                        <div class="form-group row py-3 justify-content-center">
                            <label for="income-description" class="col-lg-3 offset-lg-1 col-form-label">Descrição: </label>

                            <div class="col-lg-7">
                                <textarea
                                  name="income-description"
                                  rows="4"
                                  cols="50"
                                  class="form-control">{{ $description }}</textarea>
                            </div>
                        </div>

                        <button id="edit-{{ $slug }}" type="submit" class="btn btn-primary btn-sm btn-salvar">
                            Salvar
                        </button>
                    </form>
                </div>
            </b-modal>
        </div>                                     
    </div>

	<form method="POST"
	    action="{{ route('record.update', $recordId) }}"
	    class="cent">
	    @csrf
	    @method('PUT')

	    <div class="cent">
	        <button id="record-{{ $slug }}" type="submit" class="btn btn-primary btn-sm btn-salvar">
	        Salvar
	        </button>
	    </div>  

	    <div class="d.flex row mb-2 justify-content-center">
	        <div class="col-md-5 mb-3">
	            <label for="value">Valor</label>
	            <input type="number"
	            name="value"
	            step=".01"
                onClick="this.select();"
	            class="form-control"
	            value="{{ $recordValue }}">
	        </div>
	        
	        <div class="col-md-7 mb-3">
	            <label for="description">Observações</label>
	            <input type="text"
	            name="description"
	            class="form-control"
	            {{ $recordDescription == null ? '' : 'readonly' }}
	            value="{{ $recordDescription }}"> 
	        </div>                                 
	    </div>
	</form>
</li>