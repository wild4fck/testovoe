<template>
    <div>
        <div class="add-wrapper">
            <form class="import-form">
                <div class="form-group">
                    <label for="section-name-field">Название</label>
                    <input id="section-name-field" v-model="params.name" class="form-control" name="name" type="text">
                </div>
                <label v-if="typeof this.entry === 'undefined'" class="typo__label">Раздел</label>
                <div v-if="typeof this.entry === 'undefined'" class="form-group">
                    <multiselect v-model="parent" :allow-empty="false" :close-on-select="true" :maxHeight="100"
                                 :options="parents" :searchable="true" :show-labels="false" label="name"
                                 placeholder="">
                    </multiselect>
                </div>
                <div v-if="act === 'add'" class="form-group">
                    <label for="code-field">Код</label>
                    <input id="code-field" v-model="params.code" class="form-control" name="code" type="text">
                </div>
                <div class="form-group">
                    <label for="description-field">Описание</label><br>
                    <textarea id="description-field" v-model="params.description" class="form-control" cols="60"
                              name="description"
                              rows="5"></textarea>
                </div>
                <div class="button-panel">
                    <span v-if="loading" class="badge badge-warning mt-2">Отправка...</span>
                    <a v-if="!loading" class="btn btn-primary add-btn" @click="exec">{{ buttonTxt }}</a>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import Multiselect from 'vue-multiselect'

export default {
    name: "AddWindow",
    components: {Multiselect},
    props: {
        entry: null,
        act: '',
        item: {},
    },
    data: function () {
        return {
            loading: false,
            parents: [],
            params: {
                id: null,
                name: '',
                code: '',
                description: '',
                entry_id: null
            },
            parent: [],
        }
    },
    computed: {
        buttonTxt() {
            return (this.act === 'edit') ? 'Изменить' : 'Добавить';
        }
    },
    methods: {
        exec() {
            this.loading = true;
            let url = '';

            switch (true) {
                case this.act === 'add':
                    url = '/add-entry';
                    this.params.entry_id = (typeof this.parent.id !== 'undefined') ? this.parent.id : this.entry;
                    this.axios(url);
                    break;
                case this.act === 'edit':
                    url = '/edit-entry';
                    this.params.entry_id = (typeof this.parent.id !== 'undefined') ? this.parent.id : this.params.entry_id;
                    this.axios(url);
                    break;
            }


        },

        getEntries() {
            axios.get('/get-all-entries')
                .then((respose) => {
                    this.parents = respose.data;
                })
                .catch((error) => {

                });
        },
        axios(url) {
            axios.post(url, this.params)
                .then((response) => {
                    this.$notify({
                        group: 'message',
                        type: 'success',
                        position: 'top left',
                        title: response.data.title,
                        text: response.data.text,
                    });
                    this.loading = false;
                    this.$modal.hideAll();
                    this.$root.$emit('reload');
                })
                .catch((error) => {
                    let errorMess = '<ul>';
                    if (error.response) {
                        let arError = error.response.data.errors;
                        for (let index in arError) {
                            errorMess += '<li>';
                            errorMess += arError[index].join('</li><li>');
                        }
                    } else if (error.request) {
                        errorMess += error.request;
                    } else {
                        errorMess += error;
                    }
                    errorMess += '</li></ul>';
                    this.$notify({
                        group: 'message',
                        type: 'error',
                        position: 'top left',
                        title: 'Ошибка',
                        text: errorMess,
                    });
                    this.loading = false;
                });
        }
    },
    mounted() {
        if (this.item) {
            this.params = this.item;
        }
        this.getEntries();
        console.log(this.entry)
    }
}
</script>

<style scoped>
.add-wrapper {
    padding: 50px 35px;
}

.button-panel {
    text-align: right;
}
</style>
