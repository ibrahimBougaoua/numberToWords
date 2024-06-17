<div>
    <input type="text"
           x-model="value"
           x-on:input.debounce.500ms="convertToWords"
           placeholder="Enter a number"
           class="block w-full transition duration-75 rounded-lg shadow-sm focus:border-primary-600 focus:ring-primary-600 border-gray-300"
    />

    <div class="mt-2 text-gray-600">
        <p x-text="words"></p>
    </div>
</div>

<script>
    function numberToWords() {
        return {
            value: '',
            words: '',
            lang: 'en',
            conversionUrl: '/convert-to-words',

            convertToWords() {
                if (this.value === '') {
                    this.words = '';
                    return;
                }

                fetch(`${this.conversionUrl}?number=${this.value}&lang=${this.lang}`)
                    .then(response => response.json())
                    .then(data => {
                        this.words = data.words;
                    });
            }
        };
    }
</script>
