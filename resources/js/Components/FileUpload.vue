<script setup>
import { ref } from "vue";

const emit = defineEmits(['image']);

const props = defineProps({
  listingImage: String,
});

const currentImage = props.listingImage ? `/storage/${props.listingImage}` : null;
const previewFile = ref(currentImage);
const overSize = ref(false);

const selectFile = (e) => {
    const file = e.target.files[0];
    previewFile.value = URL.createObjectURL(file);
    overSize.value = file.size > 5242880 ;
    emit('image', file);
}
</script>
<template>
  <div>
    <span 
    class="block text-sm font-medium text-slate-700 dark:text-slate-300"
    :class="{'!text-red-600' : overSize }"
    >
    {{ overSize ? 'File size exceeds 5mb' : 'File (Max Size 5mb)'}}
    </span>

    <label
      for="file"
      class="block rounded-md mt-1 bg-slate-400 h-[60px] overflow-hidden cursor-pointer border-slate-300 border"
    >
      <img
        class="object-cover object-center h-full w-full"
        :src="previewFile ?? '/storage/images/listing/bird.jpeg'"
        alt=""
      />
    </label>

    <input @input="selectFile" type="file" name="file" id="file" hidden />
  </div>
</template>
