<template>
    <b-container fluid class="center p-4 bg-dark">
        <b-row class="text-center" v-if="list">
            <b-col class="pb-2" md="3" v-for="(document, documentIndex) in list" :key="'document_' + documentIndex">
                <b-img class="pointer" v-b-modal.pdfModal thumbnail fluid :src="document.thumbnail"
                       :alt="'Document #' + document.id" @click="openPDF(document.path)"/>
            </b-col>
        </b-row>

        <b-row v-else class="text-center text-white">
            <b-col>
                <h3>No Documents has been uploaded for now</h3>
            </b-col>
        </b-row>

        <b-modal id="pdfModal" title="PDF Preview" lazy :hide-footer="modal.hide.footer"
                 :hide-header="modal.hide.header">
            <b-row fluid>
                <b-col class="p-2" sm="12">
                    <pdf :src="pdfURI" v-if="pdfURI" :page="meta.page" @num-pages="meta.pages = $event"></pdf>
                </b-col>

                <b-col class="pb-2 text-center pointer" md="4"
                       @click="changePage(meta.page - 1)">
                    <v-icon name="arrow-left" v-if="meta.page > 1"></v-icon>
                    <v-icon name="arrow-left" class="text-muted" v-if="meta.page === 1"></v-icon>
                </b-col>
                <b-col class="text-center" md="4">
                    <span v-text="meta.page + ' / ' + (meta.pages || 1)"></span>
                </b-col>
                <b-col class="pb-2 text-center pointer" md="4"
                       @click="changePage(meta.page + 1)">
                    <v-icon name="arrow-right" v-if="meta.page < meta.pages"></v-icon>
                    <v-icon name="arrow-right" class="text-muted" v-if="meta.page === meta.pages"></v-icon>
                </b-col>

            </b-row>
        </b-modal>

    </b-container>
</template>

<script>
    import pdf from 'vue-pdf';

    export default {
        name: "DocumentsListComponent",
        components: {pdf},
        props: {
            list: {
                type: Array,
                default: []
            }
        },
        data() {
            return {
                modal: {
                    hide: {
                        footer: true,
                        header: true
                    }
                },
                pdfURI: null,
                meta: {
                    page: 1,
                    pages: 1,
                }
            }
        },
        methods: {
            openPDF(url) {
                this.meta = {
                    page: 1,
                    pages: 1
                };

                this.pdfURI = url;
            },
            changePage(page) {
                if (page >= 1 && page <= this.meta.pages) {
                    this.meta.page = page;
                }
            }
        }
    }
</script>

<style scoped>

</style>