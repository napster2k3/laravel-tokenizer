<link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">

<div id="tokenizer">
    <div style="" class="max-w-4xl rounded overflow-hidden shadow-lg" v-cloak>
        <div class="bg-purple-400 font-semibold border-b-2 border-gray-300 px-6 py-3 text-white">
            Tokenizer
            <span v-if="createToken">> Create Token</span>
            <span v-if="editToken != null">> Edit Token @{{ cEditToken.token }}</span>
            <span class="inline-block bg-white rounded-full px-3 text-sm  text-purple-400 float-right align-middle">
                @{{ model }}:@{{ modelId }}
            </span>
        </div>

        <div class="px-6 py-4" style="height: 455px">
            <div v-if="editToken != null" class="w-full ">

                <div v-if="editSuccess" class="mb-3 bg-green-100 border-l-4 border-green-500 text-green-500 p-4" role="alert">
                    <p class="font-bold"></p>
                    <p>Token updated !</p>
                </div>

                <div v-if="editError" class="mb-3 bg-red-100 border-l-4 border-red-500 text-red-500 p-4" role="alert">
                    <p class="font-bold"></p>
                    <p>Error while updating token !</p>
                </div>

                <div class="pb-4 hidden">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                           for="grid-first-name">
                        Actions
                    </label>
                    <button @click="edit" class="
                    bg-red-600 uppercase hover:shadow-lg text-white font-semibold py-1 px-4 text-xs border border-gray-400 rounded shadow
                    ">
                    Expires Now
                    </button>

                    <button @click="edit" v-if="! cEditToken.has_reached_session_limit && cEditToken.session_limit != null"
                    class="mx-1 bg-blue-600 uppercase hover:shadow-lg text-white font-semibold py-1 px-4 text-xs border border-gray-400 rounded shadow">
                    Revoke Remaining Sessions
                    </button>

                    <button @click="edit" v-if="cEditToken.user_id != null" class="
                mx-1 bg-orange-500 uppercase hover:shadow-lg text-white font-semibold py-1 px-4 text-xs border border-gray-400 rounded shadow
                ">
                    Revoke User #@{{ cEditToken.user_id }}
                    </button>
                </div>
                <div class="flex flex-wrap -mx-3 mb-6">

                    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                               for="grid-first-name">
                            Max Session Number
                        </label>
                        <input v-model="editForm.session_limit"
                               class="appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                               type="number" placeholder="">
                        <p class="text-gray-500 text-xs italic">Leave empty for no session limit.</p>
                    </div>
                    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                               for="grid-first-name">
                            Used Session Number
                        </label>
                        <input v-model="editForm.session_count"
                               class="appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                               type="number" placeholder="">
                        <p class="text-gray-500 text-xs italic">Number of terminated session.</p>
                    </div>
                    <div class="w-full md:w-1/3 px-3">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                               for="grid-last-name">
                            Session Duration
                            <small>(seconds)</small>
                        </label>
                        <input v-model="editForm.session_duration"
                               class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                               id="grid-last-name" type="number" placeholder="Doe">
                    </div>
                </div>
                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full px-3">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                               for="grid-password">
                            Expires
                        </label>
                        <input class="appearance-none block md:w-1/3 bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                               v-model="editForm.expired_at"
                               id="grid-password" type="text" placeholder="">
                        <p class="text-gray-600 text-xs italic">Leave empty for no expiration.</p>
                    </div>
                </div>
                <div class="flex flex-wrap -mx-3 mb-2">
                    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                               for="grid-state">
                            User
                        </label>
                        <div class="relative">
                            <select v-model="editForm.require_user"
                                    class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                    id="grid-state">
                                <option value="0">Guest</option>
                                <option value="1">Require</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                     viewBox="0 0 20 20">
                                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <button @click="edit" class="
                mt-5 bg-purple-500 uppercase hover:bg-gray-100 text-white font-semibold py-1 px-4 text-xs border border-gray-400 rounded shadow
                ">
                Update
                </button>

                <button @click="editToken = null" class="
                mt-5 uppercase mx-1 bg-white hover:bg-gray-100 text-gray-500 font-semibold py-1 px-4 text-xs border border-gray-400 rounded shadow
                ">
                Back to Listing
                </button>
            </div>

            <div v-else-if="createToken" class="w-full ">
                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                               for="grid-first-name">
                            Max Session Number
                        </label>
                        <input v-model="createForm.session_limit"
                               class="appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                               type="number" placeholder="">
                        <p class="text-gray-500 text-xs italic">Leave empty for no Max Session Number.</p>
                    </div>
                    <div class="w-full md:w-1/2 px-3">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                               for="grid-last-name">
                            Session Duration
                            <small>(seconds)</small>
                        </label>
                        <input v-model="createForm.session_duration"
                               class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                               id="grid-last-name" type="number" placeholder="Doe">
                    </div>
                </div>
                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full px-3">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                               for="grid-password">
                            Expires
                        </label>
                        <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                               v-model="createForm.expired_at"
                               id="grid-password" type="text" placeholder="">
                        <p class="text-gray-600 text-xs italic">Leave empty for no expiration.</p>
                    </div>
                </div>
                <div class="flex flex-wrap -mx-3 mb-2">
                    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                               for="grid-state">
                            User
                        </label>
                        <div class="relative">
                            <select v-model="createForm.require_user"
                                    class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                    id="grid-state">
                                <option value="0">Guest</option>
                                <option value="1">Require</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                     viewBox="0 0 20 20">
                                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <button @click="create" class="
                mt-5 uppercase bg-purple-500 hover:bg-gray-100 text-white font-semibold py-1 px-4 text-xs border border-gray-400 rounded shadow
                ">
                Submit
                </button>

                <button @click="createToken = false" class="
                mt-5 uppercase ml-2 bg-white hover:bg-gray-100 text-gray-500 font-semibold py-1 px-4 text-xs border border-gray-400 rounded shadow
                ">
                Cancel
                </button>
            </div>

            <div v-else>
                <div>
                    <button @click="createToken = true" class="
                    border shadow bg-purple-500 hover:bg-purple-400 focus:shadow-outline focus:outline-none text-white font-bold text-xs py-2 px-4 rounded
                    "type="button">
                    Create Token
                    </button>

                    <div class="float-right items-center">
                        <label class="inline text-gray-500 font-bold">
                            <input v-model="filterActive" class="mr-2 leading-tight" type="checkbox">
                            <span class="text-sm">
                            Active Only
                            </span>
                        </label>
                        <input type="text" placeholder="Search Token.."
                               class="ml-5 w-6/12 text-sm border-b border-purple-200 text-grey-darkest shadow rounded h-10 p-3 focus:outline-none"/>
                    </div>
                </div>

                <div class="w-full mt-5 text-sm ">
                    <div class="flex px-2 items-center my-1 bg-gray-100 font-bold uppercase text-sm text-gray-500 border-b border-grey-100">
                        <div class="text-3xl w-8 py-1 text-purple-500"></div>
                        <div class="w-1/5 py-1">
                            Token
                        </div>
                        <div class="w-2/5 py-1">
                            Guard
                        </div>
                        <div class="w-1/5">
                            Created
                        </div>
                        <div class="w-1/5">
                            Updated
                        </div>
                    </div>

                    <div v-if="tokens != null" class="relative loading">
                        <div v-for="(token, index) in cTokens" @click="editToken = index"
                             :class="{'bg-green-100': token.was_recently_created}"
                             class="flex px-2 items-center cursor-pointer my-1 hover:bg-purple-100 rounded">
                            <div :class="{'text-purple-500': token.is_active}" class="text-3xl w-8 py-1 text-purple-200">•</div>
                            <div class="w-1/5 py-1">
                                @{{ token.token  }}
                            </div>

                            <div class="w-2/5 py-1">
                                <span v-if="token.session_limit != null"
                                      class="inline-block text-xs bg-white border border-purple-200 rounded-full px-3 font-semibold text-purple-300">
                                    Session
                                </span>
                                <span v-if="token.require_user"
                                      class="inline-block text-xs bg-white border border-purple-200 rounded-full px-3 font-semibold text-purple-300">
                                    Require User
                                </span>
                                <span v-if="token.expired_at != null"
                                      class="inline-block text-xs bg-white border border-purple-200 rounded-full px-3 font-semibold text-purple-300">
                                    Expires
                                </span>
                            </div>
                            <div class="w-1/5">
                                @{{ token.created_at }}
                            </div>
                            <div class="w-1/5">
                                @{{ token.updated_at }}
                            </div>
                        </div>
                        <div class="flex justify-center" :class="{'opacity-25': fetching}">
                            <button @click="fetch(tokens.links.prev)"
                            :class="{'opacity-25': tokens.links.prev == null}"
                            class="
                            mt-5 bg-white hover:bg-gray-100 text-gray-500 font-semibold py-1 px-2 text-xs border border-gray-400 rounded shadow
                            ">
                            < Previous
                            </button>
                            <button @click="fetch(tokens.links.next)"
                            :class="{'opacity-25': tokens.links.next == null}"
                            v-bind:disabled="fetching"
                            class="
                            mt-5 ml-2 bg-white hover:bg-gray-100 text-gray-500 font-semibold py-1 px-2 text-xs border border-gray-400 rounded shadow
                            ">
                            Next >
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/vue@2.6.0/dist/vue.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.0/axios.min.js"></script>

<script>
    var model = '{!! addslashes(get_class($model)) !!}';
    var modelId = {{ $model->id }};
    var fetchRoute = '{{ route('tokenizer.list', ['tokenizeable_type' => get_class($model)]) }}';
    var editRoute = '{{ route('tokenizer.edit', '%s') }}';

    var vueTokenizer = new Vue({
        el: '#tokenizer',
        data: {
            model: null,
            modelId: null,

            editToken: null,
            editForm: {},
            editSuccess: false,
            editError: false,

            createToken: false,
            createForm: {
                session_duration: 3600,
                session_limit: '',
                expired_at: '',
                require_user: 0,
            },

            filterActive: false,

            tokens: null,
            fetching: false,
        },

        computed: {
            cEditToken() {
                if (this.editToken != null) {
                    return this.tokens.data[this.editToken];
                }
            },

            cTokens() {
                if (this.filterActive) {
                    return this.tokens.data.filter(function(item) {
                        return item.is_active === true
                    })
                }

                return this.tokens.data;
            }
        },

        watch: {
            cEditToken() {
                this.editSuccess = false;
                this.editError = false;

                if (this.editToken != null) {
                    this.editForm = {
                        session_duration: this.cEditToken.session_duration,
                        session_limit: this.cEditToken.session_limit,
                        session_count: this.cEditToken.session_count,
                        expired_at: this.cEditToken.expired_at,
                        require_user: this.cEditToken.require_user
                    }
                }
            },
        },

        created() {
            this.fetch(fetchRoute);
            this.model = model;
            this.modelId = modelId;
        },

        methods: {

            edit() {
                this.editSuccess = false;
                this.editError = false;
                axios.patch(editRoute.replace('%s', this.cEditToken.id), this.editForm)
                        .then(res => {
                            this.editSuccess = true;
                            this.tokens.data[this.editToken] = res.data.data;
                        }).catch(err => {
                            this.editError = true;
                });
            },

            create() {
                axios.post('{{ route('tokenizer.create') }}', Object.assign(this.createForm, {
                    tokenizeable_id: modelId,
                    tokenizeable_type: model
                })).then(res => {
                    this.createToken = false;
                    this.tokens.data.unshift(res.data.data);
                    this.tokens.data.pop()
                });
            },

            fetch(route) {
                this.fetching = true;
                axios.get(route)
                        .then(res => {
                            this.tokens = res.data;
                        }).catch(err => {}).then(() => {this.fetching = false;})
            }
        }
    })
</script>
