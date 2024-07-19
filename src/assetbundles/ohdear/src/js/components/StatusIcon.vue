<script>
export default {
  props: {
    status: {
      type: String,
      required: true,
      validate: value => ['good', 'ok', 'bad'].includes(value)
    }
  }
}
</script>

<template>
  <div class="oh-inline">
    <svg v-if="status === 'bad'" width="12" height="12" class="oh-fill-current oh-text-red-500" viewBox="0 0 24 24" fill="none"
         xmlns="http://www.w3.org/2000/svg">
      <path d="M0 24L12 0L24 24H0Z"/>
    </svg>

    <svg v-if="status === 'ok'" width="12" height="12" class="oh-fill-current oh-text-orange-500" viewBox="0 0 24 24" fill="none"
         xmlns="http://www.w3.org/2000/svg">
      <rect width="24" height="24"/>
    </svg>

    <svg v-if="status === 'good'" width="12" height="12" class="oh-fill-current oh-text-green-500" viewBox="0 0 24 24" fill="none"
         xmlns="http://www.w3.org/2000/svg">
      <circle cx="12" cy="12" r="12"/>
    </svg>
  </div>
</template>
