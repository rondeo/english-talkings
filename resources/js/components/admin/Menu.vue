<template>
    <v-app id="inspire">
        <v-navigation-drawer
                fixed
                :clipped="$vuetify.breakpoint.mdAndUp"
                app
                v-model="drawer"
        >
            <v-list dense>
                <template v-for="item in items">
                    <router-link class="v-list__tile v-list__tile--link theme--light" :to="{name: item.name}">
                        <v-layout
                                row
                                v-if="item.heading"
                                align-center
                                :key="item.heading"
                        >
                            <v-flex xs6>
                                <v-subheader v-if="item.heading">
                                    {{ item.heading }}
                                </v-subheader>
                            </v-flex>
                        </v-layout>

                        <v-list-tile v-else :key="item.text">
                            <v-list-tile-action>
                                <v-icon>{{ item.icon }}</v-icon>
                            </v-list-tile-action>
                            <v-list-tile-title>
                                {{ item.text }}
                            </v-list-tile-title>
                        </v-list-tile>
                    </router-link>
                </template>
            </v-list>
        </v-navigation-drawer>
        <v-toolbar
                color="blue darken-3"
                dark
                app
                :clipped-left="$vuetify.breakpoint.mdAndUp"
                fixed
        >
            <v-toolbar-title style="width: 300px" class="ml-0 pl-3">
                <v-toolbar-side-icon @click.stop="drawer = !drawer"></v-toolbar-side-icon>
                <span class="hidden-sm-and-down">Talkings Admin</span>
            </v-toolbar-title>
            <v-text-field
                    flat
                    solo-inverted
                    prepend-icon="search"
                    label="Search"
                    class="hidden-sm-and-down"
            ></v-text-field>
            <v-spacer></v-spacer>
            <v-btn icon>
                <v-icon>apps</v-icon>
            </v-btn>
            <v-btn icon>
                <v-icon>notifications</v-icon>
            </v-btn>
            <v-btn icon large>
                <v-avatar size="32px" tile>
                    <img
                            src="https://vuetifyjs.com/static/doc-images/logo.svg"
                            alt="Vuetify"
                    >
                </v-avatar>
            </v-btn>
        </v-toolbar>
        <v-content>
            <v-container fluid fill-height>
                <router-view></router-view>
            </v-container>
        </v-content>
    </v-app>
</template>

<script>
    export default {
        data: () => ({
            dialog: false,
            drawer: null,
            items: [
                { icon: 'dashboard', text: 'Dashboard', name: 'dashboard' },
                { icon: 'font_download', text: 'Articles', name: 'articles' },
                { icon: 'video_library', text: 'Video', name: 'video' },
                { icon: 'error', text: 'Facts', name: 'facts' }
            ]
        }),
        props: {
            source: String
        }
    }
</script>
