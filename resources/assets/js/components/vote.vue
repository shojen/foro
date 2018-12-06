<template>
	<div>
		<form>			
	        <button :class="vote ==1 ? 'btn-primary':'btn-default'" class="btn" @click.prevent="upvote">+1</button>
	        Puntuación actual: <strong id="current-score">{{score}}</strong>
	        <button class="btn btn-default" @click.prevent="downvote">-1</button>
	    </form>		
	</div>
</template>

<script>
	export default {
		props: ['score','vote'],
		methods: {
			upvote() {				
				axios.post(window.location.href + '/upvote')
			},
			downvote() {
				axios.post(window.location.href + '/downvote')
			}
		}

	}
</script>