<template>
    <v-container>
        <v-toolbar flat color="white">
            <v-toolbar-title>Facts</v-toolbar-title>

            <v-spacer></v-spacer>
            <v-dialog v-model="dialog" max-width="500px">
                <v-btn slot="activator" color="primary" dark class="mb-2">New Item</v-btn>
                <v-card>
                    <v-card-title>
                        <span class="headline">{{ formTitle }}</span>
                    </v-card-title>

                    <v-card-text>
                        <v-container grid-list-md>
                            <v-layout wrap>
                                <v-flex md12>
                                    <v-text-field v-model="editedItem.title" label="Title"></v-text-field>
                                </v-flex>
                                <v-flex md12>
                                    <v-checkbox
                                            v-model="editedItem.is_published"
                                            label="is_published"
                                            color="primary"
                                            hide-details
                                    ></v-checkbox>
                                </v-flex>
                            </v-layout>
                        </v-container>
                    </v-card-text>

                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="blue darken-1" flat @click.native="close">Cancel</v-btn>
                        <v-btn color="blue darken-1" flat @click.native="save">Save</v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-toolbar>
        <v-data-table
                :headers="headers"
                :items="facts"
                hide-actions
                class="elevation-1 container-fluid"
        >
            <template slot="items" slot-scope="props">
                <td>{{ props.item.title }}</td>
                <td>{{ (props.item.is_published === 1 || props.item.is_published === 'Да') ? 'Да' : 'Нет' }}</td>
                <td class="justify-center layout px-0">
                    <v-icon
                            small
                            class="mr-2"
                            @click="editItem(props.item)"
                    >
                        edit
                    </v-icon>
                    <v-icon
                            small
                            @click="deleteItem(props.item)"
                    >
                        delete
                    </v-icon>
                </td>
            </template>
            <template slot="no-data">
                <v-alert :value="true" color="error" icon="warning">
                    Sorry, nothing to display here :(
                </v-alert>
            </template>
        </v-data-table>
    </v-container>
</template>

<script>
    import {mapState} from 'vuex';
    export default {
        data: () => ({
            dialog: false,
            headers: [
                {
                    text: 'Title',
                    align: 'left',
                    value: 'title'
                },
                { text: 'Published', value: 'is_published', align: 'left' },
                { text: 'Actions', value: 'actions', sortable: false }
            ],
            editedIndex: -1,
            editedItem: {
                title: '',
                is_published: false
            },
            defaultItem: {
                title: '',
                is_published: false
            }
        }),
        computed: {
            formTitle () {
                return this.editedIndex === -1 ? 'New Fact' : 'Edit Fact'
            },
            ...mapState({
                facts: state => state.fact.facts
            })
        },

        watch: {
            dialog (val) {
                val || this.close()
            }
        },

        created () {
            this.$store.dispatch('fact/getFacts');
        },

        methods: {
            editItem (item) {
                this.editedIndex = this.facts.indexOf(item);
                this.editedItem = Object.assign({}, item);
                this.dialog = true
            },

            deleteItem (item) {
                const index = this.facts.indexOf(item);
                confirm('Are you sure you want to delete this item?') &&
                axios.post('api/facts/' + item.id, {_method: 'DELETE'}).then(() => {
                    this.facts.splice(index, 1);
                });
            },

            close () {
                this.dialog = false;
                setTimeout(() => {
                    this.editedItem = Object.assign({}, this.defaultItem);
                    this.editedIndex = -1
                }, 300)
            },

            save () {
                if (this.editedIndex > -1) {
                    let edited = this.editedIndex;
                    //this.editedIndex = this.facts.indexOf(this.editedItem);

                    let data = {
                        title: this.editedItem.title,
                        is_published: this.editedItem.is_published,
                        _method: 'PUT',
                    };

                    axios.post('api/facts/' + this.editedItem.id, data).then((response) => {
                        let newItem = response.data.data;

                        if (newItem.is_published === true) {
                            newItem.is_published = 'Да';
                        } else {
                            newItem.is_published = 'Нет';
                        }

                        Object.assign(this.facts[edited], newItem);
                    });

                } else {
                    let data = {
                        title: this.editedItem.title,
                        is_published: this.editedItem.is_published,
                    };
                    axios.post('api/facts', data).then((response) => {
                        let newItem = response.data.data;

                        if (newItem.is_published === true) {
                            newItem.is_published = 'Да';
                        } else {
                            newItem.is_published = 'Нет';
                        }

                        this.facts.push(newItem);
                    });
                }
                this.close()
            }
        }
    }
</script>
