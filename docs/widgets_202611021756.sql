INSERT INTO widgets (project_id,slug,content_type,lang,status,has_icon,`position`,title,content,footer,metadata,created_at,updated_at,deleted_at) VALUES
	 (5,'photo-blog','photo-blog','en','published',NULL,0,NULL,NULL,NULL,NULL,'2026-10-14 17:48:54','2026-10-14 17:48:54',NULL),
	 (5,'widget-container','widget','en','published',NULL,0,'Container title','{% photo-blog path="martinvach/landscape" %}


{% photo-blog path="ivnbg/hauptmarkt" %}','Container footer',NULL,'2026-10-14 17:56:32','2026-10-14 18:00:18',NULL),
	 (5,'photo-gallery','gallery','en','published',NULL,0,'Photo gallery test',NULL,NULL,NULL,'2026-10-16 15:26:55','2026-10-16 15:29:10',NULL),
	 (5,'vades-home-hero','hero','en','published','vades-hero',0,'Reliable software. AI that pays off','I help companies modernize their systems and put AI to work securely and with clear control of costs.

<a href="/pages/about" class="btn btn-wide btn-outline btn-primary my-btn-raquo">More about me</a>',NULL,NULL,'2026-10-20 16:38:34','2026-10-20 17:26:35',NULL),
	 (5,'vades-feature-1','feature','en','published','vades-feature-1',0,'AI integration into existing systems','Add AI to the software you already run, without a rewrite.','LLM integration | APIs | No rewrite',NULL,'2026-10-20 16:47:34','2026-10-20 17:25:24',NULL),
	 (5,'vades-home-features','widget','en','published',NULL,0,'What I can do for you','{% vades-feature-1 %}

{% vades-feature-2 %}

{% vades-feature-3 %}

{% vades-feature-4 %}

{% vades-feature-5 %}

{% vades-feature-6 %}',NULL,NULL,'2026-10-20 16:55:10','2026-10-20 18:09:35',NULL),
	 (5,'vades-feature-2','feature','en','published','vades-feature-2',0,'Private AI and internal knowledge search','Search your own documents in plain language, with data kept in-house.','RAG | Local LLMs  | Data privacy',NULL,'2026-10-20 17:06:20','2026-10-20 17:06:20',NULL),
	 (5,'vades-feature-3','feature','en','published','vades-feature-3',0,'AI agents and workflow automation','Hand repeatable tasks to AI, while your team keeps control.','AI agents | Workflow automation | Human approval',NULL,'2026-10-20 17:08:13','2026-10-20 17:08:13',NULL),
	 (5,'vades-feature-4','feature','en','published','vades-feature-4',0,'Legacy modernization and solution architecture','Modernize older platforms step by step, without risky big-bang rewrites.

','Microservices | Architecture | Gradual migration',NULL,'2026-10-20 17:12:59','2026-10-20 17:12:59',NULL),
	 (5,'vades-feature-5','feature','en','published','vades-feature-5',0,'Custom business software and APIs','Web applications, backends and APIs built around how you work.','Web applications | APIs | Integrations',NULL,'2026-10-20 17:14:26','2026-10-20 17:14:26',NULL);
INSERT INTO widgets (project_id,slug,content_type,lang,status,has_icon,`position`,title,content,footer,metadata,created_at,updated_at,deleted_at) VALUES
	 (5,'vades-feature-6','feature','en','published','vades-feature-6',0,'Consulting and advisory','An honest second opinion on technology, AI and costs.','Advisory | Cost control | Data security',NULL,'2026-10-20 17:21:23','2026-10-20 17:21:23',NULL),
	 (5,'vades-home-reference','widget','en','published',NULL,0,'Experience you can build on','Twenty years of building business software, a smart home platform I helped grow to more than 50,000 users, and 30+ clients on my own platform.',NULL,NULL,'2026-10-20 17:22:36','2026-10-20 17:45:35',NULL),
	 (5,'home-contact-form','contact-form','en','published',NULL,0,NULL,'<div>

	## Start with a short message
Describe your project, challenge or idea in a few lines. I will reply personally with a clear next step.

</div>',NULL,NULL,'2026-10-20 17:24:10','2026-10-20 18:25:47',NULL),
	 (5,'vades-reference-carousel','reference','en','published',NULL,0,NULL,NULL,NULL,NULL,'2026-10-26 18:33:14','2026-10-26 20:01:20',NULL);
