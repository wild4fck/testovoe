<template>
    <div>
        <ul class="navbar-nav mr-auto">
            <li v-for="el in panelItems" class="nav-item">
                <a class="nav-link" @click="el.action">
                    {{ el.label }}
                </a>
                <modal :name="el.name">
                    hello, world!
                </modal>
            </li>
        </ul>
    </div>
</template>

<script>
import ImportData from './Import.vue';
import AddWindow from './AddWindow.vue';

export default {
    name: "app-panel",
    data: function () {
        return {
            panelItems: [
                {label: 'Импорт', name: 'import', action: this.import},
                {label: '+Элемент', name: 'add-el', action: this.addEntry},
            ]
        }
    }
    ,
    methods: {
        import: function () {
            this.$modal.show(ImportData, {}, {
                draggable: true,
                width: 500,
                height: 200
            })
        },
        addEntry: function () {
            this.$modal.show(AddWindow, {act: 'add'}, {
                draggable: true,
                height: 'auto'
            })
        },
    }
}
</script>

<style>
.nav-link {
    cursor: pointer;
}
</style>
