<template>
  <main class="flex justify-center">
    <div>
      <FormKit type="form" :actions="false" #default="{ state: { valid } }">
        <FormKit label="Current password" type="password" validation="required"></FormKit>
        <FormKit label="New password" type="password" validation="required"></FormKit>
        <FormKit label="Confirm new password" type="password" validation="required"></FormKit>
        <FormKit label="Create" type="submit" :disabled="!valid" />
      </FormKit>
    </div>
  </main>
</template>
