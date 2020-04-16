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
    import Tab from "../../../components/Tab";
    import Tabs from "../../../components/Tabs";
    import Option from "./../components/Option";
    import api from "../../../lib/api";
    import _ from 'lodash';
    import ResourceForm from "../../../components/ResourceForm";

    export default {
        components: {
            ResourceForm,
            Option,
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
            console.log(this.tabsWithOptions);
            this.isLoading = false;
        },
        methods: {
            handleSuccess() {
                Cms.flash('success', 'Nice one!');
            }
        }
    }
</script>

<style>

</style>
