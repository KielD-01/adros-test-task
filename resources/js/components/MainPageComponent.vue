<template>
    <b-container class="p-2 bg-dark">
        <b-row class="pb-2 text-right">
            <b-col>
                <b-button block v-b-modal.uploadDocument>
                    <span><v-icon name="file-pdf"></v-icon></span>
                    <span>Upload Document</span>
                </b-button>
            </b-col>
        </b-row>

        <b-container fluid class="text-center p-4 bg-dark">
            <b-row>
                <b-col md="4" class="text-white">

                    <b-btn v-if="documentsMeta.current_page === 1" disabled>
                        <v-icon name="arrow-left"></v-icon>
                    </b-btn>

                    <b-btn v-else @click="getDocuments(documentsMeta.current_page - 1)">
                        <v-icon name="arrow-left"></v-icon>
                    </b-btn>
                </b-col>

                <b-col class="text-white">
                    <span v-text="documentsMeta.current_page"></span>
                    <span> / </span>
                    <span v-text="documentsMeta.last_page"></span>
                </b-col>

                <b-col md="4" class="text-white">
                    <b-btn v-if="documentsMeta.current_page === documentsMeta.last_page" disabled>
                        <v-icon name="arrow-right"></v-icon>
                    </b-btn>
                    <b-btn v-else @click="getDocuments(documentsMeta.current_page + 1)">
                        <v-icon name="arrow-right"></v-icon>
                    </b-btn>
                </b-col>
            </b-row>
        </b-container>

        <transition name="append-item">
            <DocumentsListComponent :list="documentsMeta.data"></DocumentsListComponent>
        </transition>

        <b-modal ref="uploadDocument" id="uploadDocument" title="Upload PDF Document" :hide-footer="modal.hide.footer"
                 :hide-header="modal.hide.header">

            <b-row>
                <b-col class="pb-2">
                    <b-form-file
                            v-model="document"
                            accept=".pdf"
                            placeholder="Choose a PDF document"
                            drop-placeholder="Drop a PDF document here"
                    />
                </b-col>
            </b-row>

            <b-row>
                <b-col class="pb-2 text-center">
                    <b-btn block disabled v-if="!document">
                        <span>
                            <v-icon name="upload"></v-icon>
                        </span>
                        <span>
                            Upload
                        </span>
                    </b-btn>

                    <b-btn block v-else @click="uploadDocument">
                        <span>
                            <v-icon name="upload"></v-icon>
                        </span>
                        <span>
                            Upload
                        </span>
                    </b-btn>
                </b-col>
            </b-row>


        </b-modal>

        <BlockUI :message="$store.state.blockUI.msg" :url="$store.state.blockUI.url"
                 v-show="$store.state.blockUI.visible"></BlockUI>

    </b-container>
</template>

<script>
    import DocumentsListComponent from "./elements/DocumentsListComponent";

    export default {
        name: "MainPageComponent",
        components: {DocumentsListComponent},
        data() {
            return {
                document: null,
                documentsMeta: {
                    data: null
                },
                modal: {
                    hide: {
                        footer: true,
                        header: true
                    }
                }
            }
        },
        methods: {
            getDocuments(page = null) {

                if (!page) {
                    let currentPage = this.documentsMeta.current_page || null;
                    let page = currentPage ? currentPage + 1 : 1;
                }

                this.axios.get(`/api/v1/documents?page=${page}`)
                    .then(response => {
                        this.documentsMeta = response.data.data['documents'];
                    }, error => {

                    });
            },
            uploadDocument() {
                let form = new FormData();
                form.append('pdf', this.document);

                this.axios
                    .post('/api/v1/documents', form, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    })
                    .then(() => {
                        this.$refs.uploadDocument.hide();
                        this.document = null;
                        this.$msg({text: 'Document has been successfully uploaded!', background: 'rgba(0,180,0,0.4)'});

                        this.documentsMeta = {
                            data: null
                        };

                        this.getDocuments();

                    }, error => {
                        this.$msg({text: 'Failed to upload a document', background: 'rgba(180,0,0,0.4)'});
                    });
            }
        },
        mounted() {
            this.getDocuments();
        }
    }
</script>

<style scoped>

</style>