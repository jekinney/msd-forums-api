<section class="box">
								<header class="heading">
									<h3 class="title">Quick Reply</h3>
								</header>
								<form @submit.prevent="submitQuickReply">
									<div class="field">
							            <p class="control">
							                <textarea id="editor" 
							                	v-model="reply.body" 
							                	class="textarea" 
							                	:class="{ 'is-danger': errors && errors.reply.body }"
							                ></textarea>
							            </p>
							            <p v-if="errors && errors.reply.body" class="help is-danger">{{ errors.replies.body[0] }}</p>
							        </div>   

							      	<div class="field">
							      		<button type="submit" class="button is-primary">Save</button>
							      	</div>
							    </form>
							</section>