<!-- Modal -->
<div class="modal fade" id="comment_{{ $analyse->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Donner votre commentaire</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <input type="hidden" name="dataset_id" value="{{ $analyse->dataset_id }}">

            <div class="form-group my-3">
                <label for="description">Votre commentaire sur {{ $analyse->name }}</label>
                <textarea name="description" id="description" class="form-control"></textarea>
            </div>
    
         
         
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            <button type="button" class="btn btn-primary">Ajouter</button>
          </div>
      </div>
    </div>
  </div>