<template>
    <div>
        <table class="table-fixed">
            <thead>
            <tr>
                <th class="w-1/2 px-4 py-2">Permission</th>
                <th class="w-1/4 px-4 py-2">View</th>
                <th class="w-1/4 px-4 py-2">Create</th>
                <th class="w-1/4 px-4 py-2">Update</th>
                <th class="w-1/4 px-4 py-2">Delete</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td class="border px-4 py-2">Permission1</td>
                <td class="border px-4 py-2"><input type="checkbox" id="jack" value="Jack" v-model="checkedNames"></td>
                <td class="border px-4 py-2"><input type="checkbox" id="jack" value="Jack" v-model="checkedNames"></td>
                <td class="border px-4 py-2"><input type="checkbox" id="jack" value="Jack" v-model="checkedNames"></td>
                <td class="border px-4 py-2"><input type="checkbox" id="jack" value="Jack" v-model="checkedNames"></td>
            </tr>
            <tr class="bg-gray-100">
                <td class="border px-4 py-2">Permission2</td>
                <td class="border px-4 py-2"><input type="checkbox" id="jack" value="Jack" v-model="checkedNames"></td>
                <td class="border px-4 py-2"><input type="checkbox" id="jack" value="Jack" v-model="checkedNames"></td>
                <td class="border px-4 py-2"><input type="checkbox" id="jack" value="Jack" v-model="checkedNames"></td>
                <td class="border px-4 py-2"><input type="checkbox" id="jack" value="Jack" v-model="checkedNames"></td>
            </tr>
            <tr>
                <td class="border px-4 py-2">Permission3</td>
                <td class="border px-4 py-2"><input type="checkbox" id="jack" value="Jack" v-model="checkedNames"></td>
                <td class="border px-4 py-2"><input type="checkbox" id="jack" value="Jack" v-model="checkedNames"></td>
                <td class="border px-4 py-2"><input type="checkbox" id="jack" value="Jack" v-model="checkedNames"></td>
                <td class="border px-4 py-2"><input type="checkbox" id="jack" value="Jack" v-model="checkedNames"></td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        components: {},
    }
</script>
