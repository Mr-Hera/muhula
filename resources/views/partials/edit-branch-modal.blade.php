<div class="modal fade" id="editBranch{{ $branch->id }}" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <form method="POST" action="{{ route('school.branch.update', $branch->id) }}">
      @csrf
      @method('PUT')

      <div class="modal-content">
        <div class="modal-header">
          <h5>Edit Branch</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <div class="mb-3">
            <label>School Name</label>
            <input type="text" name="school_name" class="form-control"
                   value="{{ $branch->name }}" required>
          </div>

          <div class="mb-3">
            <label>Town</label>
            <select name="town" class="form-control">
              @foreach($counties as $county)
                <option value="{{ $county->id }}"
                  {{ $branch->county_id == $county->id ? 'selected' : '' }}>
                  {{ $county->name }}
                </option>
              @endforeach
            </select>
          </div>

          <div class="mb-3">
            <label>Full Address</label>
            <input type="text" name="full_address" class="form-control"
                   value="{{ optional($branch->address)->address_text }}">
          </div>

          <div class="row">
            <div class="col">
              <label>Email</label>
              <input type="email" name="email" class="form-control"
                     value="{{ $branch->email }}">
            </div>
            <div class="col">
              <label>Phone</label>
              <input type="text" name="phone" class="form-control"
                     value="{{ $branch->phone_no }}">
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button class="btn btn-success">Save changes</button>
        </div>
      </div>
    </form>
  </div>
</div>
