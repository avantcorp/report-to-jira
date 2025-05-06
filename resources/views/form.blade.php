<div class="fixed bottom-2 right-2 md:bottom-4 md:right-4 z-[9999] bg-white text-gray-800">
    <button
            onclick="document.getElementById('reportIssuesPopup').classList.toggle('hidden')"
            class="flex items-center rounded-full bg-amber-500/50 hover:bg-amber-500 text-white font-bold shadow-md transition-all duration-300 hover:-translate-y-0.5 px-3 py-1"
    >?</button>

    <form id="reportIssuesPopup" action="{{ route('report-to-jira') }}" method="POST" class="hidden absolute -bottom-2 -right-2 md:-bottom-4 md:-right-4 w-96 max-w-[100vw] rounded-t p-2 md:p-4 border border-gray-300 bg-gray-200/50">
        @csrf
        <input type="hidden" name="reporter_name" value="{{ auth()->user()?->name }}">
        <input type="hidden" name="reporter_email" value="{{ auth()->user()?->email }}">
        <input type="hidden" name="url" value="{{ url()->current() }}">
        <textarea
                name="description" required
                placeholder="Describe the issue you're facing..."
                class="w-full min-h-[120px] p-2 border border-gray-300 rounded focus:ring-1 focus:ring-amber-500 focus:border-amber-500 outline-none resize-y text-sm shadow-inner"
        ></textarea>

        <div class="flex justify-between mt-2">
            <button type="button" onclick="document.getElementById('reportIssuesPopup').classList.toggle('hidden')"
                    class="px-4 py-2 text-gray-500 rounded border border-gray-300 text-sm">
                Cancel
            </button>
            <button type="submit"
                    class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white rounded transition-colors font-semibold text-sm">
                Report
            </button>
        </div>
    </form>
</div>