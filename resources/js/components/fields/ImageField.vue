<template>
    <FieldWrapper
        :name="field.name" :label="field.label || field.name" :errors="validationErrors" :with-shadow="false">
        <div v-if="value || dataUrl">
            <div class="py-4 flex justify-center">
                <img
                    :src="imageUrl"
                    alt
                    class="rounded w-40 h-40"
                    :class="{'rounded-full': field.rounded}"
                    ref="img"
                >
            </div>
            <div class="flex justify-around py-6">
                <button v-if="isCropping" class="btn" @click="save" type="button">Save cropped area</button>
                <button v-if="!isCropping" class="btn" @click="startCrop" type="button">Crop image</button>
                <button v-if="!isCropping" class="btn" @click="$refs.imageInput.click()" type="button">Change image
                </button>
            </div>
        </div>
        <div
            v-else
            class="h-40 flex justify-center items-center rounded border border-2 border-dashed cursor-pointer"
            @click="$refs.imageInput.click()"
        >
            <p class="text-center">Click to add image</p>
        </div>
        <input
            class="hidden"
            :class="{'border-red-600': !!hasValidationErrors}"
            :id="field.name"
            :name="field.name"
            @change="imageChanged"
            ref="imageInput"
            type="file"
        />
    </FieldWrapper>
</template>
<script>
    import FormField from "../../lib/mixins/FormField";
    import 'cropperjs/dist/cropper.css'
    import Cropper from 'cropperjs';

    export default {
        mixins: [FormField],
        data() {
            return {
                cropper: false,
                updated: false,
                reader: new FileReader(),
                dataUrl: false,
                imageBlob: false,
                isCropping: false
            }
        },
        computed: {
            imageUrl() {
                if (this.dataUrl) {
                    return this.dataUrl
                }
                return this.value;
            }
        },
        mounted() {
            this.reader.onload = event => {
                this.dataUrl = event.target.result;
                if (this.cropper) {
                    this.cropper.destroy()
                }
            };
        },
        methods: {
            // This method gets triggered when we click the "crop" button
            startCrop() {
                // We create a new Cropper instance. The first parameter is the image element
                // and the second parameter is an object with options for cropper.
                this.cropper = new Cropper(this.$refs.img, {
                    aspectRatio: 1,
                    autoCropArea: 1,
                    viewMode: 1,
                    movable: false,
                    zoomable: false
                });
                this.isCropping = true;
            },
            // This method gets triggered when we pick a new image
            imageChanged(e) {
                // We convert the image blob to a data url. Now we
                // can preview the image without uploading.
                if (e.target.files != null && e.target.files[0] != null) {
                    this.reader.readAsDataURL(e.target.files[0]);
                    this.imageBlob = e.target.files[0];
                    this.updated = true;
                }
            },
            // This method gets triggered by the save button and populates
            // the imageBlob variable with the cropped image.
            async save() {
                this.imageBlob = await new Promise(resolve => {
                    this.cropper.getCroppedCanvas(this.outputOptions).toBlob(blob => {
                        return resolve(blob);
                    })
                });
                this.reader.readAsDataURL(this.imageBlob);
                this.isCropping = false;
            },
            // This method is called by the Form to grab the value of the image field.
            // If it is updated, we provide the new value.
            fill(data) {
                if (this.updated && this.imageBlob) {
                    data[this.field.name] = this.imageBlob;
                }
                return data;
            }
        }
    }
</script>
