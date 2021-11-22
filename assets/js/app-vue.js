var app = new Vue({

	el: '#app',

	data: {

		site_url: SITE_URL,
		query: '',
		disabled: false,
		tickets: [],
		not_found: false,
		message: '',
		error: ''

	},
	created(){


	},

	methods: {

		search(){

			this.tickets = [];
			this.message = this.error = '';
			this.not_found = false;

			this.query = this.query.replace(/[&\/\\#,+()$~%.'":*?<>{}]/g, '');

			if(this.query.length < 7)
				return;

			this.disabled = true;

			fetch(`${this.site_url}/home/search/${this.query}`)
			.then(resp => resp.json())
			.then(resp => {

				this.disabled = false;

				if(resp.status == false)
					return this.not_found = true;

				this.tickets = resp.data;

			}).catch(error => {

				this.error = 'Ticket search failed gracefully. :('
				this.disabled = false;
				this.query = '';
				console.log(this.$refs);
				this.$refs.input.focus();
			})


		},

		async mark(ticket){

			if(ticket.status == 1){

				if (prompt('Enter Secret phrase') != 'convention')
					return alert('You are not authorized to perform this action');
			}

			await fetch(`${this.site_url}/home/update/${ticket.id}`)
			.then(resp => resp.json())
			.catch(err => this.error = err);

			this.tickets = [];
			this.query = '';

			if(ticket.status == 0){

				this.message = `${ticket.customer_name} is now present.`;

			}else{

				this.error = `${ticket.customer_name} has been marked as absent.`;
			}
			
			this.$refs.input.focus();
		}
	}
})