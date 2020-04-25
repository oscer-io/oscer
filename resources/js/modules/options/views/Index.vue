<template>
    <loading :loading="isLoading">
        <h1>{{$t('options.index_page_title')}}</h1>
        <Tabs :options="{ useUrlFragment: false }">
            <Tab
                v-for="(options,tab) in tabsWithOptions"
                :key="tab"
                :name="tab.charAt(0).toUpperCase() + tab.slice(1)"
                :active="tab === 'pages'"
            >
                <ResourceForm
                    v-for="option in options"
                    :key="option.model.key"
                    resource="option"
                    :resource-id="option.model.id"
                    :preloaded-resource="option"
                    @success="handleSuccess"
                />
            </Tab>
        </Tabs>
    </loading>
</template>

<script>
    import _ from 'lodash';
    import Tab from "../../../components/Tab";
    import Tabs from "../../../components/Tabs";
    import api from "../../../lib/api";
    import ResourceForm from "../../../components/ResourceForm";

    export default {
        components: {
            ResourceForm,
            Tab,
            Tabs,
        },
        data() {
            return {
                isLoading: true,
                rawOptions: false
            }
        },
        computed: {
            tabsWithOptions() {
                return _.groupBy(this.rawOptions, option => option.model.key.split('.')[0]);
            }
        },
        async mounted() {
            const response = await api(Cms.route('cms.backend.resources.index', 'option'));
            this.rawOptions = response.data.data;
            this.isLoading = false;
        },
        methods: {
            handleSuccess() {
                this.$store.dispatch('flash', {
                    type: 'success',
                    text: 'Nice one!'
                });
            }
        }
    }
</script>


<style>

</style>
