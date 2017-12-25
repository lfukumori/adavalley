@if ($errors->any())
    <avm-message inline-template>
        <article class="message is-danger" v-show="visible">
            <div class="message-header">
                <p>Form Errors:</p>
                <button class="delete" aria-label="delete" @click="visible = false"></button>
            </div>
            <div class="message-body">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </article>
    </avm-message>
@endif