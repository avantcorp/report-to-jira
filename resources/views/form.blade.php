<div class="fixed bottom-2 right-2 md:bottom-4 md:right-4 z-[9999] text-gray-800">
    <button
            onclick="document.getElementById('rtg-reportIssuesPopup').classList.toggle('hidden')"
            class="flex items-center rounded-full bg-amber-500/50 hover:bg-amber-500 text-white font-bold shadow-md transition-all duration-300 hover:-translate-y-0.5 px-3 py-1"
    >?
    </button>

    <form id="rtg-reportIssuesPopup" onsubmit="submitForm(event);"
          class="hidden absolute -bottom-2 -right-2 md:-bottom-4 md:-right-4 w-96 max-w-[100vw] rounded-t p-2 md:p-4 border border-gray-300 bg-gray-200">
        @csrf
        <input type="hidden" name="reporter_name" value="{{ auth()->user()?->name }}">
        <input type="hidden" name="reporter_email" value="{{ auth()->user()?->email }}">
        <input type="hidden" name="url" value="{{ url()->current() }}">
        <textarea
                name="description" required
                placeholder="Describe the issue you're facing..."
                class="w-full min-h-[120px] p-2 bg-gray-100 border border-gray-300 rounded focus:ring-1 focus:ring-amber-500 focus:border-amber-500 outline-none resize-y text-sm shadow-inner"
        ></textarea>

        <ul id="rtg-errors">

        </ul>

        @if(isset($errors) && $errors)
            <ul> @foreach($errors as $error)
                    <li class="text-red-600 text-sm">{{ $error }}</li>
                @endforeach </ul>
        @endif

        <div class="flex justify-between mt-2">
            <button type="button" onclick="document.getElementById('rtg-reportIssuesPopup').classList.toggle('hidden')"
                    class="px-4 py-2 text-gray-500 rounded border border-gray-500 text-sm">
                Cancel
            </button>
            <button type="button" onclick="submitForm(event)"
                    class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white rounded transition-colors font-semibold text-sm">
                Report
            </button>
        </div>
    </form>

    <script>
        function submitForm(event) {
            event.preventDefault();

            const form = document.getElementById('rtg-reportIssuesPopup');
            const errorsList = document.getElementById('rtg-errors');
            errorsList.innerHTML = '';

            fetch('{{ route('report-to-jira') }}', {
                headers: {Accept: 'application/json'},
                method: 'POST',
                body: new FormData(form)
            })
                .then(async (response) => {
                    if (response.status === 422) {
                        const errors = (await response.json()).errors
                        Object
                            .entries(errors)
                            .forEach(([key, values]) => {
                                values.forEach(value => {
                                    const li = document.createElement('li');
                                    li.classList.add('text-red-700', 'text-sm');
                                    li.innerHTML = value;
                                    errorsList.appendChild(li);
                                })
                            })

                        return;
                    }

                    form.reset()
                    form.classList.add('hidden')
                })

        }
    </script>
</div>