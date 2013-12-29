<div id="main"><!--main start-->
			<div id="content">
				<div class="content-box">
					<h1>Настройки</h1>
					<form action="/site/updateprofile/" class="settings-form">
						<fieldset>
							<div class="form-box">
								<h2>Данные для входа на сайт</h2>
								<div class="row"><!--class="active"-->
									<div class="label-holder">
										<label>Ваш e-mail</label>
									</div>
									<label class="input-holder">
										<input disabled="disabled" name="email" type="text" value="<?=$userdata['email'];?>" />
									</label>
								</div>
								<div class="row"><!--class="active"-->
									<div class="label-holder">
										<label>Пароль</label>
									</div>
									<label class="input-holder">
										<input disabled="disabled" name="password" type="password" value="" />
									</label>
									<div class="btn-right">
										<div class="green-btn">
											<span>Сохранить</span>
											<input type="button" value="Сохранить" />
										</div>
									</div>
									<div class="change-link">
										<a href="#">Изменить</a>
									</div>
								</div>
							</div>
							<div class="form-box">
								<h2>Персональные данные</h2>
								<div class="row"><!--class="active"-->
									<div class="label-holder">
										<label>Ваше имя</label>
									</div>
									<label class="input-holder">
										<input disabled="disabled" name="name" type="text" value="<?=$userdata['name'];?>" />
									</label>
									<div class="change-link">
										<a href="#">Изменить</a>
									</div>
									<div class="btn-right">
										<div class="green-btn">
											<span>Сохранить</span>
											<input type="button" value="Сохранить" />
										</div>
									</div>
								</div>
								<div class="row"><!--class="active"-->
									<div class="label-holder">
										<label>Номер телефона</label>
									</div>
									<label class="input-holder">
										<input disabled="disabled" name="phone" name="phone" type="text" value="<?=$userdata['phone'];?>" />
									</label>
									<div class="change-link">
										<a href="#">Изменить</a>
									</div>
									<div class="btn-right">
										<div class="green-btn">
											<span>Сохранить</span>
											<input type="button" value="Сохранить" />
										</div>
									</div>
								</div>
							</div>
							<div class="form-box">
								<h2>Доставка</h2>
								<!--<div class="row">
									<div class="label-holder">
										<label>Доставка</label>
									</div>
									<label class="input-holder">
										<input disabled="disabled" name="delivery_addr" type="text" value="<?=$userdata['delivery_addr'];?>" />
									</label>
								</div>-->
								<div class="row"><!--class="active"-->
									<div class="label-holder">
										<label>Адрес</label>
									</div>
									<label class="textarea-holder">
										<textarea disabled="disabled" name="delivery_addr" cols="30" rows="5"><?=$userdata['delivery_addr'];?></textarea>
									</label>
									<div class="change-link">
										<a href="#">Изменить</a>
									</div>
									<div class="btn-right">
										<div class="green-btn">
											<span>Сохранить</span>
											<input type="button" value="Сохранить" />
										</div>
									</div>
								</div>
							</div>
						</fieldset>
					</form>
				</div>
			</div>
			<?=$this->renderWidgets();?>
		</div><!--main end-->
		<div class="see-menu btn-holder center">
			<a href="/#top" class="green-btn">
				<span><?=Yii::t('frontend', 'Actualdish');?></span>
			</a>
		</div>