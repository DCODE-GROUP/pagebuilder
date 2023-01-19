<template>
	<div class="flex w-full space-x-4">
			<div class="w-3/12 px-4">
				<slot name="left" />
			</div>	
			<div class="w-9/12 px-4">
				<slot name="right" />
			</div>
		</div>
</template>