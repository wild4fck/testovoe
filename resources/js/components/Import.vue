<template>
    <div class="popup-wrapper">
        <form class="import-form">
            <div class="form-group">
                <h5><label for="file">XML - импорт</label></h5>
                <input id="file" ref="file" accept=".xml" aria-describedby="fileHelp" class="form-control"
                       type="file" @change="handleFileUpload">
                <small id="emailHelp" class="form-text text-muted">Для загрузки в базу необходимо выбрать файл c
                    расширением .xml с вашего компьютера.</small>
            </div>
            <span v-if="loading" class="badge badge-warning mt-2">Отправка...</span>
            <a v-if="!loading" class="btn btn-primary import-btn" @click="submitFile">Загрузить</a>
        </form>
    </div>
</template>

<script>
export default {
    name: "ImportData",
    data: function () {
        return {
            loading: false,
            file: ''
        }
    },
    methods: {
        handleFileUpload() {

            this.file = this.$refs.file.files[0];
        },
        submitFile() {
            this.loading = true;
            let formData = new FormData();
            formData.append('xml', this.file);
            axios.post('/import',
                formData,
                {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }
            ).then((response) => {
                console.log(response.data);
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
                        console.log(error.request);
                        errorMess += error.request;
                    } else {
                        console.log(error);
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
        },
    }
}
</script>

<style>
.popup-wrapper {
    padding: 20px;
}

.import-btn {
    position: absolute;
    right: 15px;
    bottom: 15px;
}
</style>
