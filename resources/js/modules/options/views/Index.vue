<template>
    <loading :loading="isLoading">
        <h1>{{$t('options.index_page_title')}}</h1>
        <Tabs :options="{ useUrlFragment: false }">
            <Tab
                v-if="options"
                v-for="(fields,tab) in options"
                :key="tab"
                :name="tab.charAt(0).toUpperCase() + tab.slice(1)"
                :active="tab === 'pages'"
            >
                <Option v-for="option in fields" :key="option.key" :option="option"/>
            </Tab>
        </Tabs>
    </loading>
</template>

<script>
    import Tab from "../../../components/Tab";
    import Tabs from "../../../components/Tabs";
    import Option from "./../components/Option";
    import api from "../../../lib/api";

    export default {
        components: {
            Option,
            Tab,
            Tabs,
        },
        data() {
            return {
                isLoading: true,
                options: false
            }
        },
        async mounted() {
            const response = await api(Cms.route('cms.api.resources.index', 'option'));
            this.options = response.data.data;
            this.isLoading = false;
        }
    }
</script>

<style>

</style>
