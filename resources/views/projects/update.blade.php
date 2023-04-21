<form action="{{ route('projects.update') }}" method="POST" enctype="multipart/form-data">
    @method('PUT') @csrf

    <label for="title" class="form-label">Title</label>
    <input
        type="text"
        class="form-control"
        id="title"
        name="title"
        value="{{ $project->title }}"
    />

    <label for="year" class="form-label">Year</label>
    <input
        type="text"
        class="form-control"
        id="year"
        name="year"
        value="{{ $project->year }}"
    />

    <label for="kind" class="form-label">Kind</label>
    <select class="form-select" id="kind" name="kind">
        <option value="graphic" @selected($project->kind == 'graphic')>Graphic</option>
        <option value="web" @selected($project->web == 'web')>Web</option>
        <option value="writing" @selected($project->writing == 'writing')>Writing</option>
    </select>

    <label for="time" class="form-label">Time</label>
    <input
        type="number"
        class="form-control"
        id="time"
        name="time"
        value="{{ $project->time }}"
    />


    <label for="description" class="form-label">Description</label>
    <textarea class="form-control" id="description" name="description" rows="4">
      {{ $project->description }}
    </textarea>

    <button type="submit" class="btn btn-primary">Salva</button>
</form>