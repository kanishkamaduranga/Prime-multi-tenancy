<div>
    <select onchange="window.location.href = this.value">
        @foreach($this->getLocales() as $key => $locale)
            <option value="{{ route('language.switch', $key) }}" {{ app()->getLocale() === $key ? 'selected' : '' }}>
                {{ strtoupper($locale) }}
            </option>
        @endforeach
    </select>
</div>
