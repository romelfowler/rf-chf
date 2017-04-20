<?php include('../../inc/header.php'); ?>
		<div id="announcement" class="announcement">
			<i class="fa fa-times" aria-hidden="true"></i>

			<p>
				Scroll down to view more content
			</p>
		</div>
		<div id="container" class="container">
			<div class="menu-panel">
				<h3>Table of Contents</h3>
				<ul id="menu-toc" class="menu-toc">
					<li class="menu-toc-current"><a href="#item1">Getting Started with FTP</a></li>
					<li><a href="#item2">FileZilla</a></li>
				</ul>

			</div>

			<div class="bb-custom-wrapper">
				<div id="bb-bookblock" class="bb-bookblock">
					<!-- THIS STARTS YOUR PAGE -->
					<div class="bb-item" id="item1">
						<div class="content">
							<div class="scroller">
								<h1>File Transfer Protocol (FTP)</h1>
							  <div class="container">
							  	<div class="row">
							  		<div class="col-sm-12">

											<div class="info">
												<p>
													<span>If you're not familiar with FTP, continue
														reading.</span> If your a seasoned veteran in
													the field of web development, you may want to go back to main Grid
													and click on <strong>Deliverables</strong>.

												Consider this application a resource that you can add on and expand from.
												For now, feel free to download what's already on here.
												</p>
											</div>


										<div class="col-md-6">
											<h1>Introductions</h1>

											<p>
												The easiest method of getting files onto your site,
												and once there, changing them is using a FTP (File
												transfer protocol) client.
												FTP works by transferring files from your computer to
												your site. We recommend you use
												<a href="https://filezilla-project.org/">FileZilla</a>
												which is a  free FTP software.
											</p>
											<hr>
											<h5>FTP Credentials</h5>
											<p>
												To use your FTP client you will need an FTP address of
												your site plus login name and password for it.
												All of it should be in the Login Information email you
												got after registering your hosting account with your
												hosting company.
											</p>
											<h5>Encrypt Your Files with SSH</h5>
											<p>
												For additional security, most hosting companies will
												enable a secure FTP (called SFTP) protocol for your site
												when asked.SFTP uses SSH to transfer files.
												Unlike standard FTP, it encrypts both commands and data,
												preventing passwords and sensitive information from being
												transmitted in the clear over the network.
												It is functionally similar to FTP, but must be enabled by
												your hosting company and then specified in your FTP software.
												Many WordPress hacks on shared hosting are the results
												of not using proper SFTP.
											</p>
										</div>
										<div class="col-md-6">
											<img src="img/filezilla.jpg" width="400" alt="Filezilla" />

										</div>


							  		</div>
							  	</div>
							  </div>
							</div>
						</div>
					</div>


					<div class="bb-item" id="item2">
						<div class="content">
							<div class="scroller">
							<div class="row">
								<h1>Using Filezilla</h1>
								<hr>
								<div class="col-md-12">
									<ul class="fz_instruction">
										<li>
											<p>Download and install FileZilla</p>
										</li>
										<li>
											<p>Launch FileZilla</p>
										</li>
										<li>
											<p>Enter your domain name, your username and password.</p>
										</li>
										<li>
											<p> Click Quickconnect</p>
										</li>
										<li>
											<p>Once it loads you will see the screen is split into
												two halves</p>

										</li>
										<li>
											<p> All you need to do is locate the folder you want to
												install the new files onto your WordPress install on by
												entering your upload directory — just double click on your
												root directory (public_html folder if you are using cPanelP)
												and loctate the required folder.</p>
										</li>
										<li>
											<p>Now locate the files (and/or folders) you want to upload
												on your hard drive.</p>
										</li>
										<li>
											<p>Uploading is as simple as dragging the required files
												(and/or folders) from your computer into the correct
												folder on your install.</p>
										</li>
									</ul>
								</div>

							</div>
							<hr>
							<div class="row">
								<div class="col-md-12">
									<img src="img/fz1.jpg" width="400" alt="Filezilla" />
									<img src="img/fz2.jpg" width="400" alt="Filezilla" />
									<img src="img/fz3.jpg" width="400" alt="Filezilla" />
									<img src="img/fz4.jpg" width="400" alt="Filezilla" />
									<img src="img/fz5.jpg" width="400" alt="Filezilla" />

								</div>
							</div>
							</div><!-- scroller -->
						</div>
					</div>
					<div class="bb-item" id="item3">
						<div class="content">
							<div class="scroller">


							</div>
						</div>
					</div>


				<nav>
					<span id="bb-nav-prev">&larr;</span>
					<span id="bb-nav-next">&rarr;</span>
				</nav>

				<span id="tblcontents" class="menu-button">Table of Contents</span>

			</div>

		</div><!-- /container -->


		<?php include('../../inc/footer.php'); ?>
