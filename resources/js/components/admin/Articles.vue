<template>
    <v-container>
        <v-toolbar flat color="white">
            <v-toolbar-title>Articles</v-toolbar-title>

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
                                    <v-textarea v-model="editedItem.text" label="Text"></v-textarea>
                                </v-flex>
                                <v-flex md12>
                                    <v-img v-if="editedItem.img"
                                            :src="editedItem.img"
                                            class="grey lighten-2"
                                    ></v-img>
                                    <upload-btn  :fileChangedCallback="fileChanged" v-model="editedItem.img"></upload-btn>
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
                :items="articles"
                hide-actions
                class="elevation-1 container-fluid"
        >
            <template slot="items" slot-scope="props">
                <td>{{ props.item.title }}</td>
                <td>{{ props.item.text }}</td>
                <td>
                    <v-img v-if="props.item.img !== ''"
                            :src="props.item.img"
                            class="grey lighten-2"
                    ></v-img>
                </td>
                <td>{{ (props.item.is_published === 1 || props.item.is_published === 'Да') ? 'Да' : 'Нет' }}</td>
                <td class="text-xs-right">
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
    import UploadButton from 'vuetify-upload-button';

    export default {
        components: {
            'upload-btn': UploadButton
        },

        data: () => ({
            file: undefined,
            dialog: false,
            headers: [
                { text: 'Title', align: 'left', value: 'title'},
                { text: 'Text', value: 'text', align: 'left' },
                { text: 'Image', value: 'img', align: 'left' },
                { text: 'Published', value: 'is_published', align: 'left' },
                { text: 'Actions', value: 'actions', sortable: false, align: 'right' }
            ],
            editedIndex: -1,
            editedItem: {
                title: '',
                img: {},
                text: '',
                is_published: false,
            },
            defaultItem: {
                title: '',
                img: {},
                text: '',
                is_published: false,
            }
        }),

        computed: {
            formTitle () {
                return this.editedIndex === -1 ? 'New Article' : 'Edit Article'
            },
            ...mapState({
                articles: state => state.article.articles
            })
        },

        watch: {
            dialog (val) {
                val || this.close()
            }
        },

        created () {
            this.$store.dispatch('article/getArticles');
        },

        methods: {
            editItem (item) {
                this.editedIndex = this.articles.indexOf(item);
                this.editedItem = Object.assign({}, item);
                this.dialog = true
            },

            deleteItem (item) {
                const index = this.articles.indexOf(item);
                confirm('Are you sure you want to delete this item?') &&
                axios.post('api/articles/' + item.id, {_method: 'DELETE'}).then(() => {
                    this.articles.splice(index, 1);
                });
            },

            close () {
                this.dialog = false;
                setTimeout(() => {
                    this.editedItem = Object.assign({}, this.defaultItem);
                    this.editedIndex = -1
                }, 300)
            },

            fileChanged (file) {
                this.file = file;
            },

            save () {
                let formData = new FormData();
                if (this.file !== undefined) {
                    formData.append('img', this.file);
                }
                formData.append('title', this.editedItem.title);
                formData.append('text', this.editedItem.text);
                formData.append('is_published', (this.editedItem.is_published ? 1 : 0));
                formData.append('tags', 1);

                if (this.editedIndex > -1) {
                    formData.append('_method', 'PUT');
                    let edited = this.editedIndex;
                    axios.post('api/articles/' + this.editedItem.id, formData, { headers: { 'Content-Type': 'multipart/form-data' }}).then((response) => {
                        let newItem = response.data.data;

                        if (newItem.is_published === true) {
                            newItem.is_published = 'Да';
                        } else {
                            newItem.is_published = 'Нет';
                        }

                        Object.assign(this.articles[edited], newItem);
                    });

                } else {
                    axios.post('api/articles', formData).then((response) => {
                        let newItem = response.data.data;

                        if (newItem.is_published === true) {
                            newItem.is_published = 'Да';
                        } else {
                            newItem.is_published = 'Нет';
                        }

                        this.articles.push(newItem);
                    });
                }
                this.close()
            }
        }
    }
</script>
