<!--suppress ES6CheckImport, JSUnusedGlobalSymbols -->
<template>
    <div>
        <div class="d-flex justify-content-center">
            <div v-if="active.id" class="card" style="width: 18rem;">
                <div class="close-cart" @click="active = {}">X</div>
                <div class="card-body">
                    <b><h5 class="card-title">Название: {{ active.name }}</h5></b>
                    <p class="card-text">Код: {{ active.code }}</p>
                    <p class="card-text">Описание: {{ active.description }}</p>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="search">Поиск</label>
            <input id="search" v-model="searchString" class="form-control" type="text" @change="search">
        </div>
        <div class="d-flex justify-content-end">
            <a class="btn btn-outline-info" @click="toggleRepresentation">Лейбл - {{ view }}</a>
        </div>
        <MyLoader v-if="loading"></MyLoader>
        <div v-if="!loading">
            <h4 v-if="entries.length === 0">Ничего не найдено =(</h4>
            <v-treeview
                :expand-icon="'arrow_right'"
                :items="entries"
                activatable
                dense
                hoverable
                rounded
                selection-type="independent">
                <template v-slot:label="{ item }">
                    <div @click="active = item">{{ item[view] }}</div>
                </template>
                <template v-slot:append="{ item, open }">
                    <v-icon class="my-icons" @click="add(item)">add_circle</v-icon>
                    <v-icon class="my-icons" @click="edit(item)">edit</v-icon>
                    <v-icon class="my-icons" @click="deleteItem(item.id)">delete</v-icon>
                </template>
            </v-treeview>
        </div>
    </div>
</template>

<script>
import AddWindow from './AddWindow.vue';
import MyLoader from './MyLoader.vue'

export default {
    name: 'main-app',
    components: {
        MyLoader
    },
    data: function () {
        return {
            entries: [],
            searchString: '',
            loading: true,
            view: 'name',
            active: {}
        }
    },
    methods: {
        toggleRepresentation() {
            this.view = (this.view === 'code') ? 'name' : 'code';
        },
        getTree() {
            this.loading = true;
            axios.get('/get-all-entries-tree')
                .then((respose) => {
                    this.entries = respose.data;
                    this.loading = false;
                })
                .catch((error) => {
                });
        },
        search() {
            this.loading = true;
            if (this.searchString !== '') {
                axios.post('/search', {searchString: this.searchString})
                    .then((respose) => {
                        this.entries = respose.data;
                        this.loading = false;
                    })
                    .catch((error) => {
                    });
            } else {
                this.getTree();
            }
        },
        add(item) {
            this.$modal.show(AddWindow, {entry: item.id, act: 'add'}, {
                draggable: true,
                height: 'auto'
            })
        },
        log(item) {
            console.log(item)
        },
        edit(item) {
            this.$modal.show(AddWindow, {
                item: item,
                act: 'edit'
            }, {
                draggable: true,
                height: 'auto'
            })
        },
        deleteItem(id) {
            confirm('Точно удалить?');
            {
                axios.post('/delete', {id: id})
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
        }
    },
    mounted() {
        this.getTree();
        this.$root.$on('reload', () => {
            if (this.searchString === '') {
                this.getTree();
            } else {
                this.search();
            }
        });

    }
}
</script>

<style>
.v-treeview-node__toggle--open {
    transform: rotate(90deg);
    -ms-transform: rotate(90deg);
    -webkit-transform: rotate(90deg);
}

.my-icons {
    font-size: 20px !important;
}

.close-cart {
    transform: rotate(-360deg);
    display: block;
    width: fit-content;
    position: absolute;
    right: 5px;
    cursor: pointer;
    transition: all ease-in-out 0.5s;
}

.close-cart:hover {
    transform: rotate(360deg);
}
</style>
