# Skills glossary

## How to reference skills in chat

In **Agent chat** (Cmd+I / Ctrl+I), type **`/`** to open the menu, then pick a skill—or type the slash command directly.

**Manual invoke:** `/{folder-name}` where `{folder-name}` is the **directory** that contains `SKILL.md` (kebab-case), e.g. `/php-pro`, `/wiki-qa`, `/create-skill`.

That matches the [Agent Skills](https://cursor.com/docs/context/skills) pattern: a skill at `~/.cursor/skills/my-skill/SKILL.md` is invoked as `/my-skill`.

If the YAML `name` in frontmatter differs from the folder name (e.g. title case vs kebab-case), **use the folder name** for slash—see **In chat** on each entry below.

Skills are also applied automatically when the agent decides they fit, using the `description` field—unless the skill sets `disable-model-invocation: true` (then only explicit `/…` works, like `/shell`).

---

Auto-generated from local `SKILL.md` files (YAML `name` + `description`).

Search roots: `~/.cursor/skills/skills`, `~/.cursor/skills`, `~/.cursor/skills-cursor`, `~/.codex/skills`, `~/.cursor/plugins/cache`.

**Total skills:** 879

---

## `2d-games`

**In chat:** `/2d-games`

2D game development principles. Sprites, tilemaps, physics, camera.

*Source:* `/Users/elliesmith/.cursor/skills/skills/game-development/2d-games/SKILL.md`

## `3d-games`

**In chat:** `/3d-games`

3D game development principles. Rendering, shaders, physics, cameras.

*Source:* `/Users/elliesmith/.cursor/skills/skills/game-development/3d-games/SKILL.md`

## `3d-web-experience`

**In chat:** `/3d-web-experience`

"Expert in building 3D experiences for the web - Three.js, React Three Fiber, Spline, WebGL, and interactive 3D scenes. Covers product configurators, 3D portfolios, immersive websites, and bringing depth to web experiences. Use when: 3D website, three.js, WebGL, react three fiber, 3D experience."

*Source:* `/Users/elliesmith/.cursor/skills/skills/3d-web-experience/SKILL.md`

## `ab-test-setup`

**In chat:** `/ab-test-setup`

Structured guide for setting up A/B tests with mandatory gates for hypothesis, metrics, and execution readiness.

*Source:* `/Users/elliesmith/.cursor/skills/skills/ab-test-setup/SKILL.md`

## `accessibility-compliance-accessibility-audit`

**In chat:** `/accessibility-compliance-accessibility-audit`

"You are an accessibility expert specializing in WCAG compliance, inclusive design, and assistive technology compatibility. Conduct audits, identify barriers, and provide remediation guidance."

*Source:* `/Users/elliesmith/.cursor/skills/skills/accessibility-compliance-accessibility-audit/SKILL.md`

## `Active Directory Attacks`

**In chat:** `/active-directory-attacks`

This skill should be used when the user asks to "attack Active Directory", "exploit AD", "Kerberoasting", "DCSync", "pass-the-hash", "BloodHound enumeration", "Golden Ticket", "Silver Ticket", "AS-REP roasting", "NTLM relay", or needs guidance on Windows domain penetration testing.

*Source:* `/Users/elliesmith/.cursor/skills/skills/active-directory-attacks/SKILL.md`

## `activecampaign-automation`

**In chat:** `/activecampaign-automation`

"Automate ActiveCampaign tasks via Rube MCP (Composio): manage contacts, tags, list subscriptions, automation enrollment, and tasks. Always search tools first for current schemas."

*Source:* `/Users/elliesmith/.cursor/skills/skills/activecampaign-automation/SKILL.md`

## `address-github-comments`

**In chat:** `/address-github-comments`

Use when you need to address review or issue comments on an open GitHub Pull Request using the gh CLI.

*Source:* `/Users/elliesmith/.cursor/skills/skills/address-github-comments/SKILL.md`

## `agent-evaluation`

**In chat:** `/agent-evaluation`

"Testing and benchmarking LLM agents including behavioral testing, capability assessment, reliability metrics, and production monitoring—where even top agents achieve less than 50% on real-world benchmarks Use when: agent testing, agent evaluation, benchmark agents, agent reliability, test agent."

*Source:* `/Users/elliesmith/.cursor/skills/skills/agent-evaluation/SKILL.md`

## `agent-framework-azure-ai-py`

**In chat:** `/agent-framework-azure-ai-py`

Build Azure AI Foundry agents using the Microsoft Agent Framework Python SDK (agent-framework-azure-ai). Use when creating persistent agents with AzureAIAgentsProvider, using hosted tools (code interpreter, file search, web search), integrating MCP servers, managing conversation threads, or implementing streaming responses. Covers function tools, structured outputs, and multi-tool agents.

*Source:* `/Users/elliesmith/.cursor/skills/skills/agent-framework-azure-ai-py/SKILL.md`

## `agent-manager-skill`

**In chat:** `/agent-manager-skill`

Manage multiple local CLI agents via tmux sessions (start/stop/monitor/assign) with cron-friendly scheduling.

*Source:* `/Users/elliesmith/.cursor/skills/skills/agent-manager-skill/SKILL.md`

## `agent-memory-mcp`

**In chat:** `/agent-memory-mcp`

A hybrid memory system that provides persistent, searchable knowledge management for AI agents (Architecture, Patterns, Decisions).

*Source:* `/Users/elliesmith/.cursor/skills/skills/agent-memory-mcp/SKILL.md`

## `agent-memory-systems`

**In chat:** `/agent-memory-systems`

"Memory is the cornerstone of intelligent agents. Without it, every interaction starts from zero. This skill covers the architecture of agent memory: short-term (context window), long-term (vector stores), and the cognitive architectures that organize them. Key insight: Memory isn't just storage - it's retrieval. A million stored facts mean nothing if you can't find the right one. Chunking, embedding, and retrieval strategies determine whether your agent remembers or forgets. The field is fragm"

*Source:* `/Users/elliesmith/.cursor/skills/skills/agent-memory-systems/SKILL.md`

## `agent-orchestration-improve-agent`

**In chat:** `/agent-orchestration-improve-agent`

"Systematic improvement of existing agents through performance analysis, prompt engineering, and continuous iteration."

*Source:* `/Users/elliesmith/.cursor/skills/skills/agent-orchestration-improve-agent/SKILL.md`

## `agent-orchestration-multi-agent-optimize`

**In chat:** `/agent-orchestration-multi-agent-optimize`

"Optimize multi-agent systems with coordinated profiling, workload distribution, and cost-aware orchestration. Use when improving agent performance, throughput, or reliability."

*Source:* `/Users/elliesmith/.cursor/skills/skills/agent-orchestration-multi-agent-optimize/SKILL.md`

## `agent-tool-builder`

**In chat:** `/agent-tool-builder`

"Tools are how AI agents interact with the world. A well-designed tool is the difference between an agent that works and one that hallucinates, fails silently, or costs 10x more tokens than necessary. This skill covers tool design from schema to error handling. JSON Schema best practices, description writing that actually helps the LLM, validation, and the emerging MCP standard that's becoming the lingua franca for AI tools. Key insight: Tool descriptions are more important than tool implementa"

*Source:* `/Users/elliesmith/.cursor/skills/skills/agent-tool-builder/SKILL.md`

## `agents-v2-py`

**In chat:** `/agents-v2-py`

Build container-based Foundry Agents using Azure AI Projects SDK with ImageBasedHostedAgentDefinition. Use when creating hosted agents that run custom code in Azure AI Foundry with your own container images. Triggers: "ImageBasedHostedAgentDefinition", "hosted agent", "container agent", "Foundry Agent", "create_version", "ProtocolVersionRecord", "AgentProtocol.RESPONSES", "custom agent image".

*Source:* `/Users/elliesmith/.cursor/skills/skills/agents-v2-py/SKILL.md`

## `ai-agents-architect`

**In chat:** `/ai-agents-architect`

"Expert in designing and building autonomous AI agents. Masters tool use, memory systems, planning strategies, and multi-agent orchestration. Use when: build agent, AI agent, autonomous agent, tool use, function calling."

*Source:* `/Users/elliesmith/.cursor/skills/skills/ai-agents-architect/SKILL.md`

## `ai-engineer`

**In chat:** `/ai-engineer`

Build production-ready LLM applications, advanced RAG systems, and intelligent agents. Implements vector search, multimodal AI, agent orchestration, and enterprise AI integrations. Use PROACTIVELY for LLM features, chatbots, AI agents, or AI-powered applications.

*Source:* `/Users/elliesmith/.cursor/skills/skills/ai-engineer/SKILL.md`

## `ai-product`

**In chat:** `/ai-product`

"Every product will be AI-powered. The question is whether you'll build it right or ship a demo that falls apart in production. This skill covers LLM integration patterns, RAG architecture, prompt engineering that scales, AI UX that users trust, and cost optimization that doesn't bankrupt you. Use when: keywords, file_patterns, code_patterns."

*Source:* `/Users/elliesmith/.cursor/skills/skills/ai-product/SKILL.md`

## `ai-wrapper-product`

**In chat:** `/ai-wrapper-product`

"Expert in building products that wrap AI APIs (OpenAI, Anthropic, etc.) into focused tools people will pay for. Not just 'ChatGPT but different' - products that solve specific problems with AI. Covers prompt engineering for products, cost management, rate limiting, and building defensible AI businesses. Use when: AI wrapper, GPT product, AI tool, wrap AI, AI SaaS."

*Source:* `/Users/elliesmith/.cursor/skills/skills/ai-wrapper-product/SKILL.md`

## `airflow-dag-patterns`

**In chat:** `/airflow-dag-patterns`

Build production Apache Airflow DAGs with best practices for operators, sensors, testing, and deployment. Use when creating data pipelines, orchestrating workflows, or scheduling batch jobs.

*Source:* `/Users/elliesmith/.cursor/skills/skills/airflow-dag-patterns/SKILL.md`

## `airtable-automation`

**In chat:** `/airtable-automation`

"Automate Airtable tasks via Rube MCP (Composio): records, bases, tables, fields, views. Always search tools first for current schemas."

*Source:* `/Users/elliesmith/.cursor/skills/skills/airtable-automation/SKILL.md`

## `algolia-search`

**In chat:** `/algolia-search`

"Expert patterns for Algolia search implementation, indexing strategies, React InstantSearch, and relevance tuning Use when: adding search to, algolia, instantsearch, search api, search functionality."

*Source:* `/Users/elliesmith/.cursor/skills/skills/algolia-search/SKILL.md`

## `algorithmic-art`

**In chat:** `/algorithmic-art`

Creating algorithmic art using p5.js with seeded randomness and interactive parameter exploration. Use this when users request creating art using code, generative art, algorithmic art, flow fields, or particle systems. Create original algorithmic art rather than copying existing artists' work to avoid copyright violations.

*Source:* `/Users/elliesmith/.cursor/skills/skills/algorithmic-art/SKILL.md`

## `amplitude-automation`

**In chat:** `/amplitude-automation`

"Automate Amplitude tasks via Rube MCP (Composio): events, user activity, cohorts, user identification. Always search tools first for current schemas."

*Source:* `/Users/elliesmith/.cursor/skills/skills/amplitude-automation/SKILL.md`

## `analytics-tracking`

**In chat:** `/analytics-tracking`

Design, audit, and improve analytics tracking systems that produce reliable, decision-ready data. Use when the user wants to set up, fix, or evaluate analytics tracking (GA4, GTM, product analytics, events, conversions, UTMs). This skill focuses on measurement strategy, signal quality, and validation— not just firing events.

*Source:* `/Users/elliesmith/.cursor/skills/skills/analytics-tracking/SKILL.md`

## `angular`

**In chat:** `/angular`

Modern Angular (v20+) expert with deep knowledge of Signals, Standalone Components, Zoneless applications, SSR/Hydration, and reactive patterns. Use PROACTIVELY for Angular development, component architecture, state management, performance optimization, and migration to modern patterns.

*Source:* `/Users/elliesmith/.cursor/skills/skills/angular/SKILL.md`

## `angular-best-practices`

**In chat:** `/angular-best-practices`

Angular performance optimization and best practices guide. Use when writing, reviewing, or refactoring Angular code for optimal performance, bundle size, and rendering efficiency.

*Source:* `/Users/elliesmith/.cursor/skills/skills/angular-best-practices/SKILL.md`

## `angular-migration`

**In chat:** `/angular-migration`

Migrate from AngularJS to Angular using hybrid mode, incremental component rewriting, and dependency injection updates. Use when upgrading AngularJS applications, planning framework migrations, or modernizing legacy Angular code.

*Source:* `/Users/elliesmith/.cursor/skills/skills/angular-migration/SKILL.md`

## `angular-state-management`

**In chat:** `/angular-state-management`

Master modern Angular state management with Signals, NgRx, and RxJS. Use when setting up global state, managing component stores, choosing between state solutions, or migrating from legacy patterns.

*Source:* `/Users/elliesmith/.cursor/skills/skills/angular-state-management/SKILL.md`

## `angular-ui-patterns`

**In chat:** `/angular-ui-patterns`

Modern Angular UI patterns for loading states, error handling, and data display. Use when building UI components, handling async data, or managing component states.

*Source:* `/Users/elliesmith/.cursor/skills/skills/angular-ui-patterns/SKILL.md`

## `anti-reversing-techniques`

**In chat:** `/anti-reversing-techniques`

Understand anti-reversing, obfuscation, and protection techniques encountered during software analysis. Use when analyzing protected binaries, bypassing anti-debugging for authorized analysis, or understanding software protection mechanisms.

*Source:* `/Users/elliesmith/.cursor/skills/skills/anti-reversing-techniques/SKILL.md`

## `antigravity-workflows`

**In chat:** `/antigravity-workflows`

"Orchestrate multiple Antigravity skills through guided workflows for SaaS MVP delivery, security audits, AI agent builds, and browser QA."

*Source:* `/Users/elliesmith/.cursor/skills/skills/antigravity-workflows/SKILL.md`

## `API Fuzzing for Bug Bounty`

**In chat:** `/api-fuzzing-bug-bounty`

This skill should be used when the user asks to "test API security", "fuzz APIs", "find IDOR vulnerabilities", "test REST API", "test GraphQL", "API penetration testing", "bug bounty API testing", or needs guidance on API security assessment techniques.

*Source:* `/Users/elliesmith/.cursor/skills/skills/api-fuzzing-bug-bounty/SKILL.md`

## `api-design-principles`

**In chat:** `/api-design-principles`

Master REST and GraphQL API design principles to build intuitive, scalable, and maintainable APIs that delight developers. Use when designing new APIs, reviewing API specifications, or establishing API design standards.

*Source:* `/Users/elliesmith/.cursor/skills/skills/api-design-principles/SKILL.md`

## `api-documentation-generator`

**In chat:** `/api-documentation-generator`

"Generate comprehensive, developer-friendly API documentation from code, including endpoints, parameters, examples, and best practices"

*Source:* `/Users/elliesmith/.cursor/skills/skills/api-documentation-generator/SKILL.md`

## `api-documenter`

**In chat:** `/api-documenter`

Master API documentation with OpenAPI 3.1, AI-powered tools, and modern developer experience practices. Create interactive docs, generate SDKs, and build comprehensive developer portals. Use PROACTIVELY for API documentation or developer portal creation.

*Source:* `/Users/elliesmith/.cursor/skills/skills/api-documenter/SKILL.md`

## `api-patterns`

**In chat:** `/api-patterns`

API design principles and decision-making. REST vs GraphQL vs tRPC selection, response formats, versioning, pagination.

*Source:* `/Users/elliesmith/.cursor/skills/skills/api-patterns/SKILL.md`

## `api-security-best-practices`

**In chat:** `/api-security-best-practices`

"Implement secure API design patterns including authentication, authorization, input validation, rate limiting, and protection against common API vulnerabilities"

*Source:* `/Users/elliesmith/.cursor/skills/skills/api-security-best-practices/SKILL.md`

## `api-testing-observability-api-mock`

**In chat:** `/api-testing-observability-api-mock`

"You are an API mocking expert specializing in realistic mock services for development, testing, and demos. Design mocks that simulate real API behavior and enable parallel development."

*Source:* `/Users/elliesmith/.cursor/skills/skills/api-testing-observability-api-mock/SKILL.md`

## `app-builder`

**In chat:** `/app-builder`

Main application building orchestrator. Creates full-stack applications from natural language requests. Determines project type, selects tech stack, coordinates agents.

*Source:* `/Users/elliesmith/.cursor/skills/skills/app-builder/SKILL.md`

## `app-store-optimization`

**In chat:** `/app-store-optimization`

Complete App Store Optimization (ASO) toolkit for researching, optimizing, and tracking mobile app performance on Apple App Store and Google Play Store

*Source:* `/Users/elliesmith/.cursor/skills/skills/app-store-optimization/SKILL.md`

## `application-performance-performance-optimization`

**In chat:** `/application-performance-performance-optimization`

"Optimize end-to-end application performance with profiling, observability, and backend/frontend tuning. Use when coordinating performance optimization across the stack."

*Source:* `/Users/elliesmith/.cursor/skills/skills/application-performance-performance-optimization/SKILL.md`

## `architect-review`

**In chat:** `/architect-review`

Master software architect specializing in modern architecture patterns, clean architecture, microservices, event-driven systems, and DDD. Reviews system designs and code changes for architectural integrity, scalability, and maintainability. Use PROACTIVELY for architectural decisions.

*Source:* `/Users/elliesmith/.cursor/skills/skills/architect-review/SKILL.md`

## `architecture`

**In chat:** `/architecture`

Architectural decision-making framework. Requirements analysis, trade-off evaluation, ADR documentation. Use when making architecture decisions or analyzing system design.

*Source:* `/Users/elliesmith/.cursor/skills/skills/architecture/SKILL.md`

## `architecture-decision-records`

**In chat:** `/architecture-decision-records`

Write and maintain Architecture Decision Records (ADRs) following best practices for technical decision documentation. Use when documenting significant technical decisions, reviewing past architectural choices, or establishing decision processes.

*Source:* `/Users/elliesmith/.cursor/skills/skills/architecture-decision-records/SKILL.md`

## `architecture-patterns`

**In chat:** `/architecture-patterns`

Implement proven backend architecture patterns including Clean Architecture, Hexagonal Architecture, and Domain-Driven Design. Use when architecting complex backend systems or refactoring existing applications for better maintainability.

*Source:* `/Users/elliesmith/.cursor/skills/skills/architecture-patterns/SKILL.md`

## `arm-cortex-expert`

**In chat:** `/arm-cortex-expert`

Senior embedded software engineer specializing in firmware and driver development for ARM Cortex-M microcontrollers (Teensy, STM32, nRF52, SAMD). Decades of experience writing reliable, optimized, and maintainable embedded code with deep expertise in memory barriers, DMA/cache coherency, interrupt-driven I/O, and peripheral drivers.

*Source:* `/Users/elliesmith/.cursor/skills/skills/arm-cortex-expert/SKILL.md`

## `asana-automation`

**In chat:** `/asana-automation`

"Automate Asana tasks via Rube MCP (Composio): tasks, projects, sections, teams, workspaces. Always search tools first for current schemas."

*Source:* `/Users/elliesmith/.cursor/skills/skills/asana-automation/SKILL.md`

## `async-python-patterns`

**In chat:** `/async-python-patterns`

Master Python asyncio, concurrent programming, and async/await patterns for high-performance applications. Use when building async APIs, concurrent systems, or I/O-bound applications requiring non-blocking operations.

*Source:* `/Users/elliesmith/.cursor/skills/skills/async-python-patterns/SKILL.md`

## `attack-tree-construction`

**In chat:** `/attack-tree-construction`

Build comprehensive attack trees to visualize threat paths. Use when mapping attack scenarios, identifying defense gaps, or communicating security risks to stakeholders.

*Source:* `/Users/elliesmith/.cursor/skills/skills/attack-tree-construction/SKILL.md`

## `audio-transcriber`

**In chat:** `/audio-transcriber`

"Transform audio recordings into professional Markdown documentation with intelligent summaries using LLM integration"

*Source:* `/Users/elliesmith/.cursor/skills/skills/audio-transcriber/SKILL.md`

## `auth-implementation-patterns`

**In chat:** `/auth-implementation-patterns`

Master authentication and authorization patterns including JWT, OAuth2, session management, and RBAC to build secure, scalable access control systems. Use when implementing auth systems, securing APIs, or debugging security issues.

*Source:* `/Users/elliesmith/.cursor/skills/skills/auth-implementation-patterns/SKILL.md`

## `automate-whatsapp`

**In chat:** `/automate-whatsapp`

"Build WhatsApp automations with Kapso workflows: configure WhatsApp triggers, edit workflow graphs, manage executions, deploy functions, and use databases/integrations for state. Use when automating WhatsApp conversations and event handling."

*Source:* `/Users/elliesmith/.cursor/skills/skills/automate-whatsapp/SKILL.md`

## `autonomous-agent-patterns`

**In chat:** `/autonomous-agent-patterns`

"Design patterns for building autonomous coding agents. Covers tool integration, permission systems, browser automation, and human-in-the-loop workflows. Use when building AI agents, designing tool APIs, implementing permission systems, or creating autonomous coding assistants."

*Source:* `/Users/elliesmith/.cursor/skills/skills/autonomous-agent-patterns/SKILL.md`

## `autonomous-agents`

**In chat:** `/autonomous-agents`

"Autonomous agents are AI systems that can independently decompose goals, plan actions, execute tools, and self-correct without constant human guidance. The challenge isn't making them capable - it's making them reliable. Every extra decision multiplies failure probability. This skill covers agent loops (ReAct, Plan-Execute), goal decomposition, reflection patterns, and production reliability. Key insight: compounding error rates kill autonomous agents. A 95% success rate per step drops to 60% b"

*Source:* `/Users/elliesmith/.cursor/skills/skills/autonomous-agents/SKILL.md`

## `avalonia-layout-zafiro`

**In chat:** `/avalonia-layout-zafiro`

Guidelines for modern Avalonia UI layout using Zafiro.Avalonia, emphasizing shared styles, generic components, and avoiding XAML redundancy.

*Source:* `/Users/elliesmith/.cursor/skills/skills/avalonia-layout-zafiro/SKILL.md`

## `avalonia-viewmodels-zafiro`

**In chat:** `/avalonia-viewmodels-zafiro`

Optimal ViewModel and Wizard creation patterns for Avalonia using Zafiro and ReactiveUI.

*Source:* `/Users/elliesmith/.cursor/skills/skills/avalonia-viewmodels-zafiro/SKILL.md`

## `avalonia-zafiro-development`

**In chat:** `/avalonia-zafiro-development`

Mandatory skills, conventions, and behavioral rules for Avalonia UI development using the Zafiro toolkit.

*Source:* `/Users/elliesmith/.cursor/skills/skills/avalonia-zafiro-development/SKILL.md`

## `AWS Penetration Testing`

**In chat:** `/aws-penetration-testing`

This skill should be used when the user asks to "pentest AWS", "test AWS security", "enumerate IAM", "exploit cloud infrastructure", "AWS privilege escalation", "S3 bucket testing", "metadata SSRF", "Lambda exploitation", or needs guidance on Amazon Web Services security assessment.

*Source:* `/Users/elliesmith/.cursor/skills/skills/aws-penetration-testing/SKILL.md`

## `aws-serverless`

**In chat:** `/aws-serverless`

"Specialized skill for building production-ready serverless applications on AWS. Covers Lambda functions, API Gateway, DynamoDB, SQS/SNS event-driven patterns, SAM/CDK deployment, and cold start optimization."

*Source:* `/Users/elliesmith/.cursor/skills/skills/aws-serverless/SKILL.md`

## `aws-skills`

**In chat:** `/aws-skills`

"AWS development with infrastructure automation and cloud architecture patterns"

*Source:* `/Users/elliesmith/.cursor/skills/skills/aws-skills/SKILL.md`

## `azd-deployment`

**In chat:** `/azd-deployment`

Deploy containerized applications to Azure Container Apps using Azure Developer CLI (azd). Use when setting up azd projects, writing azure.yaml configuration, creating Bicep infrastructure for Container Apps, configuring remote builds with ACR, implementing idempotent deployments, managing environment variables across local/.azure/Bicep, or troubleshooting azd up failures. Triggers on requests for azd configuration, Container Apps deployment, multi-service deployments, and infrastructure-as-code with Bicep.

*Source:* `/Users/elliesmith/.cursor/skills/skills/azd-deployment/SKILL.md`

## `azure-ai-agents-persistent-dotnet`

**In chat:** `/azure-ai-agents-persistent-dotnet`

Azure AI Agents Persistent SDK for .NET. Low-level SDK for creating and managing AI agents with threads, messages, runs, and tools. Use for agent CRUD, conversation threads, streaming responses, function calling, file search, and code interpreter. Triggers: "PersistentAgentsClient", "persistent agents", "agent threads", "agent runs", "streaming agents", "function calling agents .NET".

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-ai-agents-persistent-dotnet/SKILL.md`

## `azure-ai-agents-persistent-java`

**In chat:** `/azure-ai-agents-persistent-java`

Azure AI Agents Persistent SDK for Java. Low-level SDK for creating and managing AI agents with threads, messages, runs, and tools. Triggers: "PersistentAgentsClient", "persistent agents java", "agent threads java", "agent runs java", "streaming agents java".

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-ai-agents-persistent-java/SKILL.md`

## `azure-ai-anomalydetector-java`

**In chat:** `/azure-ai-anomalydetector-java`

Build anomaly detection applications with Azure AI Anomaly Detector SDK for Java. Use when implementing univariate/multivariate anomaly detection, time-series analysis, or AI-powered monitoring.

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-ai-anomalydetector-java/SKILL.md`

## `azure-ai-contentsafety-java`

**In chat:** `/azure-ai-contentsafety-java`

Build content moderation applications with Azure AI Content Safety SDK for Java. Use when implementing text/image analysis, blocklist management, or harm detection for hate, violence, sexual content, and self-harm.

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-ai-contentsafety-java/SKILL.md`

## `azure-ai-contentsafety-py`

**In chat:** `/azure-ai-contentsafety-py`

Azure AI Content Safety SDK for Python. Use for detecting harmful content in text and images with multi-severity classification. Triggers: "azure-ai-contentsafety", "ContentSafetyClient", "content moderation", "harmful content", "text analysis", "image analysis".

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-ai-contentsafety-py/SKILL.md`

## `azure-ai-contentsafety-ts`

**In chat:** `/azure-ai-contentsafety-ts`

Analyze text and images for harmful content using Azure AI Content Safety (@azure-rest/ai-content-safety). Use when moderating user-generated content, detecting hate speech, violence, sexual content, or self-harm, or managing custom blocklists.

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-ai-contentsafety-ts/SKILL.md`

## `azure-ai-contentunderstanding-py`

**In chat:** `/azure-ai-contentunderstanding-py`

Azure AI Content Understanding SDK for Python. Use for multimodal content extraction from documents, images, audio, and video. Triggers: "azure-ai-contentunderstanding", "ContentUnderstandingClient", "multimodal analysis", "document extraction", "video analysis", "audio transcription".

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-ai-contentunderstanding-py/SKILL.md`

## `azure-ai-document-intelligence-dotnet`

**In chat:** `/azure-ai-document-intelligence-dotnet`

Azure AI Document Intelligence SDK for .NET. Extract text, tables, and structured data from documents using prebuilt and custom models. Use for invoice processing, receipt extraction, ID document analysis, and custom document models. Triggers: "Document Intelligence", "DocumentIntelligenceClient", "form recognizer", "invoice extraction", "receipt OCR", "document analysis .NET".

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-ai-document-intelligence-dotnet/SKILL.md`

## `azure-ai-document-intelligence-ts`

**In chat:** `/azure-ai-document-intelligence-ts`

Extract text, tables, and structured data from documents using Azure Document Intelligence (@azure-rest/ai-document-intelligence). Use when processing invoices, receipts, IDs, forms, or building custom document models.

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-ai-document-intelligence-ts/SKILL.md`

## `azure-ai-formrecognizer-java`

**In chat:** `/azure-ai-formrecognizer-java`

Build document analysis applications with Azure Document Intelligence (Form Recognizer) SDK for Java. Use when extracting text, tables, key-value pairs from documents, receipts, invoices, or building custom document models.

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-ai-formrecognizer-java/SKILL.md`

## `azure-ai-ml-py`

**In chat:** `/azure-ai-ml-py`

Azure Machine Learning SDK v2 for Python. Use for ML workspaces, jobs, models, datasets, compute, and pipelines. Triggers: "azure-ai-ml", "MLClient", "workspace", "model registry", "training jobs", "datasets".

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-ai-ml-py/SKILL.md`

## `azure-ai-openai-dotnet`

**In chat:** `/azure-ai-openai-dotnet`

Azure OpenAI SDK for .NET. Client library for Azure OpenAI and OpenAI services. Use for chat completions, embeddings, image generation, audio transcription, and assistants. Triggers: "Azure OpenAI", "AzureOpenAIClient", "ChatClient", "chat completions .NET", "GPT-4", "embeddings", "DALL-E", "Whisper", "OpenAI .NET".

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-ai-openai-dotnet/SKILL.md`

## `azure-ai-projects-dotnet`

**In chat:** `/azure-ai-projects-dotnet`

Azure AI Projects SDK for .NET. High-level client for Azure AI Foundry projects including agents, connections, datasets, deployments, evaluations, and indexes. Use for AI Foundry project management, versioned agents, and orchestration. Triggers: "AI Projects", "AIProjectClient", "Foundry project", "versioned agents", "evaluations", "datasets", "connections", "deployments .NET".

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-ai-projects-dotnet/SKILL.md`

## `azure-ai-projects-java`

**In chat:** `/azure-ai-projects-java`

Azure AI Projects SDK for Java. High-level SDK for Azure AI Foundry project management including connections, datasets, indexes, and evaluations. Triggers: "AIProjectClient java", "azure ai projects java", "Foundry project java", "ConnectionsClient", "DatasetsClient", "IndexesClient".

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-ai-projects-java/SKILL.md`

## `azure-ai-projects-py`

**In chat:** `/azure-ai-projects-py`

Build AI applications using the Azure AI Projects Python SDK (azure-ai-projects). Use when working with Foundry project clients, creating versioned agents with PromptAgentDefinition, running evaluations, managing connections/deployments/datasets/indexes, or using OpenAI-compatible clients. This is the high-level Foundry SDK - for low-level agent operations, use azure-ai-agents-python skill.

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-ai-projects-py/SKILL.md`

## `azure-ai-projects-ts`

**In chat:** `/azure-ai-projects-ts`

Build AI applications using Azure AI Projects SDK for JavaScript (@azure/ai-projects). Use when working with Foundry project clients, agents, connections, deployments, datasets, indexes, evaluations, or getting OpenAI clients.

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-ai-projects-ts/SKILL.md`

## `azure-ai-textanalytics-py`

**In chat:** `/azure-ai-textanalytics-py`

Azure AI Text Analytics SDK for sentiment analysis, entity recognition, key phrases, language detection, PII, and healthcare NLP. Use for natural language processing on text. Triggers: "text analytics", "sentiment analysis", "entity recognition", "key phrase", "PII detection", "TextAnalyticsClient".

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-ai-textanalytics-py/SKILL.md`

## `azure-ai-transcription-py`

**In chat:** `/azure-ai-transcription-py`

Azure AI Transcription SDK for Python. Use for real-time and batch speech-to-text transcription with timestamps and diarization. Triggers: "transcription", "speech to text", "Azure AI Transcription", "TranscriptionClient".

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-ai-transcription-py/SKILL.md`

## `azure-ai-translation-document-py`

**In chat:** `/azure-ai-translation-document-py`

Azure AI Document Translation SDK for batch translation of documents with format preservation. Use for translating Word, PDF, Excel, PowerPoint, and other document formats at scale. Triggers: "document translation", "batch translation", "translate documents", "DocumentTranslationClient".

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-ai-translation-document-py/SKILL.md`

## `azure-ai-translation-text-py`

**In chat:** `/azure-ai-translation-text-py`

Azure AI Text Translation SDK for real-time text translation, transliteration, language detection, and dictionary lookup. Use for translating text content in applications. Triggers: "text translation", "translator", "translate text", "transliterate", "TextTranslationClient".

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-ai-translation-text-py/SKILL.md`

## `azure-ai-translation-ts`

**In chat:** `/azure-ai-translation-ts`

Build translation applications using Azure Translation SDKs for JavaScript (@azure-rest/ai-translation-text, @azure-rest/ai-translation-document). Use when implementing text translation, transliteration, language detection, or batch document translation.

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-ai-translation-ts/SKILL.md`

## `azure-ai-vision-imageanalysis-java`

**In chat:** `/azure-ai-vision-imageanalysis-java`

Build image analysis applications with Azure AI Vision SDK for Java. Use when implementing image captioning, OCR text extraction, object detection, tagging, or smart cropping.

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-ai-vision-imageanalysis-java/SKILL.md`

## `azure-ai-vision-imageanalysis-py`

**In chat:** `/azure-ai-vision-imageanalysis-py`

Azure AI Vision Image Analysis SDK for captions, tags, objects, OCR, people detection, and smart cropping. Use for computer vision and image understanding tasks. Triggers: "image analysis", "computer vision", "OCR", "object detection", "ImageAnalysisClient", "image caption".

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-ai-vision-imageanalysis-py/SKILL.md`

## `azure-ai-voicelive-dotnet`

**In chat:** `/azure-ai-voicelive-dotnet`

Azure AI Voice Live SDK for .NET. Build real-time voice AI applications with bidirectional WebSocket communication. Use for voice assistants, conversational AI, real-time speech-to-speech, and voice-enabled chatbots. Triggers: "voice live", "real-time voice", "VoiceLiveClient", "VoiceLiveSession", "voice assistant .NET", "bidirectional audio", "speech-to-speech".

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-ai-voicelive-dotnet/SKILL.md`

## `azure-ai-voicelive-java`

**In chat:** `/azure-ai-voicelive-java`

Azure AI VoiceLive SDK for Java. Real-time bidirectional voice conversations with AI assistants using WebSocket. Triggers: "VoiceLiveClient java", "voice assistant java", "real-time voice java", "audio streaming java", "voice activity detection java".

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-ai-voicelive-java/SKILL.md`

## `azure-ai-voicelive-py`

**In chat:** `/azure-ai-voicelive-py`

Build real-time voice AI applications using Azure AI Voice Live SDK (azure-ai-voicelive). Use this skill when creating Python applications that need real-time bidirectional audio communication with Azure AI, including voice assistants, voice-enabled chatbots, real-time speech-to-speech translation, voice-driven avatars, or any WebSocket-based audio streaming with AI models. Supports Server VAD (Voice Activity Detection), turn-based conversation, function calling, MCP tools, avatar integration, and transcription.

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-ai-voicelive-py/SKILL.md`

## `azure-ai-voicelive-ts`

**In chat:** `/azure-ai-voicelive-ts`

Azure AI Voice Live SDK for JavaScript/TypeScript. Build real-time voice AI applications with bidirectional WebSocket communication. Use for voice assistants, conversational AI, real-time speech-to-speech, and voice-enabled chatbots in Node.js or browser environments. Triggers: "voice live", "real-time voice", "VoiceLiveClient", "VoiceLiveSession", "voice assistant TypeScript", "bidirectional audio", "speech-to-speech JavaScript".

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-ai-voicelive-ts/SKILL.md`

## `azure-appconfiguration-java`

**In chat:** `/azure-appconfiguration-java`

Azure App Configuration SDK for Java. Centralized application configuration management with key-value settings, feature flags, and snapshots. Triggers: "ConfigurationClient java", "app configuration java", "feature flag java", "configuration setting java", "azure config java".

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-appconfiguration-java/SKILL.md`

## `azure-appconfiguration-py`

**In chat:** `/azure-appconfiguration-py`

Azure App Configuration SDK for Python. Use for centralized configuration management, feature flags, and dynamic settings. Triggers: "azure-appconfiguration", "AzureAppConfigurationClient", "feature flags", "configuration", "key-value settings".

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-appconfiguration-py/SKILL.md`

## `azure-appconfiguration-ts`

**In chat:** `/azure-appconfiguration-ts`

Build applications using Azure App Configuration SDK for JavaScript (@azure/app-configuration). Use when working with configuration settings, feature flags, Key Vault references, dynamic refresh, or centralized configuration management.

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-appconfiguration-ts/SKILL.md`

## `azure-communication-callautomation-java`

**In chat:** `/azure-communication-callautomation-java`

Build call automation workflows with Azure Communication Services Call Automation Java SDK. Use when implementing IVR systems, call routing, call recording, DTMF recognition, text-to-speech, or AI-powered call flows.

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-communication-callautomation-java/SKILL.md`

## `azure-communication-callingserver-java`

**In chat:** `/azure-communication-callingserver-java`

Azure Communication Services CallingServer (legacy) Java SDK. Note - This SDK is deprecated. Use azure-communication-callautomation instead for new projects. Only use this skill when maintaining legacy code.

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-communication-callingserver-java/SKILL.md`

## `azure-communication-chat-java`

**In chat:** `/azure-communication-chat-java`

Build real-time chat applications with Azure Communication Services Chat Java SDK. Use when implementing chat threads, messaging, participants, read receipts, typing notifications, or real-time chat features.

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-communication-chat-java/SKILL.md`

## `azure-communication-common-java`

**In chat:** `/azure-communication-common-java`

Azure Communication Services common utilities for Java. Use when working with CommunicationTokenCredential, user identifiers, token refresh, or shared authentication across ACS services.

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-communication-common-java/SKILL.md`

## `azure-communication-sms-java`

**In chat:** `/azure-communication-sms-java`

Send SMS messages with Azure Communication Services SMS Java SDK. Use when implementing SMS notifications, alerts, OTP delivery, bulk messaging, or delivery reports.

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-communication-sms-java/SKILL.md`

## `azure-compute-batch-java`

**In chat:** `/azure-compute-batch-java`

Azure Batch SDK for Java. Run large-scale parallel and HPC batch jobs with pools, jobs, tasks, and compute nodes. Triggers: "BatchClient java", "azure batch java", "batch pool java", "batch job java", "HPC java", "parallel computing java".

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-compute-batch-java/SKILL.md`

## `azure-containerregistry-py`

**In chat:** `/azure-containerregistry-py`

Azure Container Registry SDK for Python. Use for managing container images, artifacts, and repositories. Triggers: "azure-containerregistry", "ContainerRegistryClient", "container images", "docker registry", "ACR".

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-containerregistry-py/SKILL.md`

## `azure-cosmos-db-py`

**In chat:** `/azure-cosmos-db-py`

Build Azure Cosmos DB NoSQL services with Python/FastAPI following production-grade patterns. Use when implementing database client setup with dual auth (DefaultAzureCredential + emulator), service layer classes with CRUD operations, partition key strategies, parameterized queries, or TDD patterns for Cosmos. Triggers on phrases like "Cosmos DB", "NoSQL database", "document store", "add persistence", "database service layer", or "Python Cosmos SDK".

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-cosmos-db-py/SKILL.md`

## `azure-cosmos-java`

**In chat:** `/azure-cosmos-java`

Azure Cosmos DB SDK for Java. NoSQL database operations with global distribution, multi-model support, and reactive patterns. Triggers: "CosmosClient java", "CosmosAsyncClient", "cosmos database java", "cosmosdb java", "document database java".

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-cosmos-java/SKILL.md`

## `azure-cosmos-py`

**In chat:** `/azure-cosmos-py`

Azure Cosmos DB SDK for Python (NoSQL API). Use for document CRUD, queries, containers, and globally distributed data. Triggers: "cosmos db", "CosmosClient", "container", "document", "NoSQL", "partition key".

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-cosmos-py/SKILL.md`

## `azure-cosmos-rust`

**In chat:** `/azure-cosmos-rust`

Azure Cosmos DB SDK for Rust (NoSQL API). Use for document CRUD, queries, containers, and globally distributed data. Triggers: "cosmos db rust", "CosmosClient rust", "container", "document rust", "NoSQL rust", "partition key".

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-cosmos-rust/SKILL.md`

## `azure-cosmos-ts`

**In chat:** `/azure-cosmos-ts`

Azure Cosmos DB JavaScript/TypeScript SDK (@azure/cosmos) for data plane operations. Use for CRUD operations on documents, queries, bulk operations, and container management. Triggers: "Cosmos DB", "@azure/cosmos", "CosmosClient", "document CRUD", "NoSQL queries", "bulk operations", "partition key", "container.items".

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-cosmos-ts/SKILL.md`

## `azure-data-tables-java`

**In chat:** `/azure-data-tables-java`

Build table storage applications with Azure Tables SDK for Java. Use when working with Azure Table Storage or Cosmos DB Table API for NoSQL key-value data, schemaless storage, or structured data at scale.

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-data-tables-java/SKILL.md`

## `azure-data-tables-py`

**In chat:** `/azure-data-tables-py`

Azure Tables SDK for Python (Storage and Cosmos DB). Use for NoSQL key-value storage, entity CRUD, and batch operations. Triggers: "table storage", "TableServiceClient", "TableClient", "entities", "PartitionKey", "RowKey".

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-data-tables-py/SKILL.md`

## `azure-eventgrid-dotnet`

**In chat:** `/azure-eventgrid-dotnet`

Azure Event Grid SDK for .NET. Client library for publishing and consuming events with Azure Event Grid. Use for event-driven architectures, pub/sub messaging, CloudEvents, and EventGridEvents. Triggers: "Event Grid", "EventGridPublisherClient", "CloudEvent", "EventGridEvent", "publish events .NET", "event-driven", "pub/sub".

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-eventgrid-dotnet/SKILL.md`

## `azure-eventgrid-java`

**In chat:** `/azure-eventgrid-java`

Build event-driven applications with Azure Event Grid SDK for Java. Use when publishing events, implementing pub/sub patterns, or integrating with Azure services via events.

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-eventgrid-java/SKILL.md`

## `azure-eventgrid-py`

**In chat:** `/azure-eventgrid-py`

Azure Event Grid SDK for Python. Use for publishing events, handling CloudEvents, and event-driven architectures. Triggers: "event grid", "EventGridPublisherClient", "CloudEvent", "EventGridEvent", "publish events".

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-eventgrid-py/SKILL.md`

## `azure-eventhub-dotnet`

**In chat:** `/azure-eventhub-dotnet`

Azure Event Hubs SDK for .NET. Use for high-throughput event streaming: sending events (EventHubProducerClient, EventHubBufferedProducerClient), receiving events (EventProcessorClient with checkpointing), partition management, and real-time data ingestion. Triggers: "Event Hubs", "event streaming", "EventHubProducerClient", "EventProcessorClient", "send events", "receive events", "checkpointing", "partition".

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-eventhub-dotnet/SKILL.md`

## `azure-eventhub-java`

**In chat:** `/azure-eventhub-java`

Build real-time streaming applications with Azure Event Hubs SDK for Java. Use when implementing event streaming, high-throughput data ingestion, or building event-driven architectures.

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-eventhub-java/SKILL.md`

## `azure-eventhub-py`

**In chat:** `/azure-eventhub-py`

Azure Event Hubs SDK for Python streaming. Use for high-throughput event ingestion, producers, consumers, and checkpointing. Triggers: "event hubs", "EventHubProducerClient", "EventHubConsumerClient", "streaming", "partitions".

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-eventhub-py/SKILL.md`

## `azure-eventhub-rust`

**In chat:** `/azure-eventhub-rust`

Azure Event Hubs SDK for Rust. Use for sending and receiving events, streaming data ingestion. Triggers: "event hubs rust", "ProducerClient rust", "ConsumerClient rust", "send event rust", "streaming rust".

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-eventhub-rust/SKILL.md`

## `azure-eventhub-ts`

**In chat:** `/azure-eventhub-ts`

Build event streaming applications using Azure Event Hubs SDK for JavaScript (@azure/event-hubs). Use when implementing high-throughput event ingestion, real-time analytics, IoT telemetry, or event-driven architectures with partitioned consumers.

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-eventhub-ts/SKILL.md`

## `azure-functions`

**In chat:** `/azure-functions`

"Expert patterns for Azure Functions development including isolated worker model, Durable Functions orchestration, cold start optimization, and production patterns. Covers .NET, Python, and Node.js programming models. Use when: azure function, azure functions, durable functions, azure serverless, function app."

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-functions/SKILL.md`

## `azure-identity-dotnet`

**In chat:** `/azure-identity-dotnet`

Azure Identity SDK for .NET. Authentication library for Azure SDK clients using Microsoft Entra ID. Use for DefaultAzureCredential, managed identity, service principals, and developer credentials. Triggers: "Azure Identity", "DefaultAzureCredential", "ManagedIdentityCredential", "ClientSecretCredential", "authentication .NET", "Azure auth", "credential chain".

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-identity-dotnet/SKILL.md`

## `azure-identity-java`

**In chat:** `/azure-identity-java`

Azure Identity Java SDK for authentication with Azure services. Use when implementing DefaultAzureCredential, managed identity, service principal, or any Azure authentication pattern in Java applications.

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-identity-java/SKILL.md`

## `azure-identity-py`

**In chat:** `/azure-identity-py`

Azure Identity SDK for Python authentication. Use for DefaultAzureCredential, managed identity, service principals, and token caching. Triggers: "azure-identity", "DefaultAzureCredential", "authentication", "managed identity", "service principal", "credential".

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-identity-py/SKILL.md`

## `azure-identity-rust`

**In chat:** `/azure-identity-rust`

Azure Identity SDK for Rust authentication. Use for DeveloperToolsCredential, ManagedIdentityCredential, ClientSecretCredential, and token-based authentication. Triggers: "azure-identity", "DeveloperToolsCredential", "authentication rust", "managed identity rust", "credential rust".

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-identity-rust/SKILL.md`

## `azure-identity-ts`

**In chat:** `/azure-identity-ts`

Authenticate to Azure services using Azure Identity SDK for JavaScript (@azure/identity). Use when configuring authentication with DefaultAzureCredential, managed identity, service principals, or interactive browser login.

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-identity-ts/SKILL.md`

## `azure-keyvault-certificates-rust`

**In chat:** `/azure-keyvault-certificates-rust`

Azure Key Vault Certificates SDK for Rust. Use for creating, importing, and managing certificates. Triggers: "keyvault certificates rust", "CertificateClient rust", "create certificate rust", "import certificate rust".

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-keyvault-certificates-rust/SKILL.md`

## `azure-keyvault-keys-rust`

**In chat:** `/azure-keyvault-keys-rust`

Azure Key Vault Keys SDK for Rust. Use for creating, managing, and using cryptographic keys. Triggers: "keyvault keys rust", "KeyClient rust", "create key rust", "encrypt rust", "sign rust".

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-keyvault-keys-rust/SKILL.md`

## `azure-keyvault-keys-ts`

**In chat:** `/azure-keyvault-keys-ts`

Manage cryptographic keys using Azure Key Vault Keys SDK for JavaScript (@azure/keyvault-keys). Use when creating, encrypting/decrypting, signing, or rotating keys.

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-keyvault-keys-ts/SKILL.md`

## `azure-keyvault-py`

**In chat:** `/azure-keyvault-py`

Azure Key Vault SDK for Python. Use for secrets, keys, and certificates management with secure storage. Triggers: "key vault", "SecretClient", "KeyClient", "CertificateClient", "secrets", "encryption keys".

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-keyvault-py/SKILL.md`

## `azure-keyvault-secrets-rust`

**In chat:** `/azure-keyvault-secrets-rust`

Azure Key Vault Secrets SDK for Rust. Use for storing and retrieving secrets, passwords, and API keys. Triggers: "keyvault secrets rust", "SecretClient rust", "get secret rust", "set secret rust".

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-keyvault-secrets-rust/SKILL.md`

## `azure-keyvault-secrets-ts`

**In chat:** `/azure-keyvault-secrets-ts`

Manage secrets using Azure Key Vault Secrets SDK for JavaScript (@azure/keyvault-secrets). Use when storing and retrieving application secrets or configuration values.

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-keyvault-secrets-ts/SKILL.md`

## `azure-maps-search-dotnet`

**In chat:** `/azure-maps-search-dotnet`

Azure Maps SDK for .NET. Location-based services including geocoding, routing, rendering, geolocation, and weather. Use for address search, directions, map tiles, IP geolocation, and weather data. Triggers: "Azure Maps", "MapsSearchClient", "MapsRoutingClient", "MapsRenderingClient", "geocoding .NET", "route directions", "map tiles", "geolocation".

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-maps-search-dotnet/SKILL.md`

## `azure-messaging-webpubsub-java`

**In chat:** `/azure-messaging-webpubsub-java`

Build real-time web applications with Azure Web PubSub SDK for Java. Use when implementing WebSocket-based messaging, live updates, chat applications, or server-to-client push notifications.

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-messaging-webpubsub-java/SKILL.md`

## `azure-messaging-webpubsubservice-py`

**In chat:** `/azure-messaging-webpubsubservice-py`

Azure Web PubSub Service SDK for Python. Use for real-time messaging, WebSocket connections, and pub/sub patterns. Triggers: "azure-messaging-webpubsubservice", "WebPubSubServiceClient", "real-time", "WebSocket", "pub/sub".

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-messaging-webpubsubservice-py/SKILL.md`

## `azure-mgmt-apicenter-dotnet`

**In chat:** `/azure-mgmt-apicenter-dotnet`

Azure API Center SDK for .NET. Centralized API inventory management with governance, versioning, and discovery. Use for creating API services, workspaces, APIs, versions, definitions, environments, deployments, and metadata schemas. Triggers: "API Center", "ApiCenterService", "ApiCenterWorkspace", "ApiCenterApi", "API inventory", "API governance", "API versioning", "API catalog", "API discovery".

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-mgmt-apicenter-dotnet/SKILL.md`

## `azure-mgmt-apicenter-py`

**In chat:** `/azure-mgmt-apicenter-py`

Azure API Center Management SDK for Python. Use for managing API inventory, metadata, and governance across your organization. Triggers: "azure-mgmt-apicenter", "ApiCenterMgmtClient", "API Center", "API inventory", "API governance".

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-mgmt-apicenter-py/SKILL.md`

## `azure-mgmt-apimanagement-dotnet`

**In chat:** `/azure-mgmt-apimanagement-dotnet`

Azure Resource Manager SDK for API Management in .NET. Use for MANAGEMENT PLANE operations: creating/managing APIM services, APIs, products, subscriptions, policies, users, groups, gateways, and backends via Azure Resource Manager. Triggers: "API Management", "APIM service", "create APIM", "manage APIs", "ApiManagementServiceResource", "API policies", "APIM products", "APIM subscriptions".

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-mgmt-apimanagement-dotnet/SKILL.md`

## `azure-mgmt-apimanagement-py`

**In chat:** `/azure-mgmt-apimanagement-py`

Azure API Management SDK for Python. Use for managing APIM services, APIs, products, subscriptions, and policies. Triggers: "azure-mgmt-apimanagement", "ApiManagementClient", "APIM", "API gateway", "API Management".

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-mgmt-apimanagement-py/SKILL.md`

## `azure-mgmt-applicationinsights-dotnet`

**In chat:** `/azure-mgmt-applicationinsights-dotnet`

Azure Application Insights SDK for .NET. Application performance monitoring and observability resource management. Use for creating Application Insights components, web tests, workbooks, analytics items, and API keys. Triggers: "Application Insights", "ApplicationInsights", "App Insights", "APM", "application monitoring", "web tests", "availability tests", "workbooks".

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-mgmt-applicationinsights-dotnet/SKILL.md`

## `azure-mgmt-arizeaiobservabilityeval-dotnet`

**In chat:** `/azure-mgmt-arizeaiobservabilityeval-dotnet`

Azure Resource Manager SDK for Arize AI Observability and Evaluation (.NET). Use when managing Arize AI organizations on Azure via Azure Marketplace, creating/updating/deleting Arize resources, or integrating Arize ML observability into .NET applications. Triggers: "Arize AI", "ML observability", "ArizeAIObservabilityEval", "Arize organization".

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-mgmt-arizeaiobservabilityeval-dotnet/SKILL.md`

## `azure-mgmt-botservice-dotnet`

**In chat:** `/azure-mgmt-botservice-dotnet`

Azure Resource Manager SDK for Bot Service in .NET. Management plane operations for creating and managing Azure Bot resources, channels (Teams, DirectLine, Slack), and connection settings. Triggers: "Bot Service", "BotResource", "Azure Bot", "DirectLine channel", "Teams channel", "bot management .NET", "create bot".

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-mgmt-botservice-dotnet/SKILL.md`

## `azure-mgmt-botservice-py`

**In chat:** `/azure-mgmt-botservice-py`

Azure Bot Service Management SDK for Python. Use for creating, managing, and configuring Azure Bot Service resources. Triggers: "azure-mgmt-botservice", "AzureBotService", "bot management", "conversational AI", "bot channels".

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-mgmt-botservice-py/SKILL.md`

## `azure-mgmt-fabric-dotnet`

**In chat:** `/azure-mgmt-fabric-dotnet`

Azure Resource Manager SDK for Fabric in .NET. Use for MANAGEMENT PLANE operations: provisioning, scaling, suspending/resuming Microsoft Fabric capacities, checking name availability, and listing SKUs via Azure Resource Manager. Triggers: "Fabric capacity", "create capacity", "suspend capacity", "resume capacity", "Fabric SKU", "provision Fabric", "ARM Fabric", "FabricCapacityResource".

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-mgmt-fabric-dotnet/SKILL.md`

## `azure-mgmt-fabric-py`

**In chat:** `/azure-mgmt-fabric-py`

Azure Fabric Management SDK for Python. Use for managing Microsoft Fabric capacities and resources. Triggers: "azure-mgmt-fabric", "FabricMgmtClient", "Fabric capacity", "Microsoft Fabric", "Power BI capacity".

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-mgmt-fabric-py/SKILL.md`

## `azure-mgmt-mongodbatlas-dotnet`

**In chat:** `/azure-mgmt-mongodbatlas-dotnet`

Manage MongoDB Atlas Organizations as Azure ARM resources using Azure.ResourceManager.MongoDBAtlas SDK. Use when creating, updating, listing, or deleting MongoDB Atlas organizations through Azure Marketplace integration. This SDK manages the Azure-side organization resource, not Atlas clusters/databases directly.

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-mgmt-mongodbatlas-dotnet/SKILL.md`

## `azure-mgmt-weightsandbiases-dotnet`

**In chat:** `/azure-mgmt-weightsandbiases-dotnet`

Azure Weights & Biases SDK for .NET. ML experiment tracking and model management via Azure Marketplace. Use for creating W&B instances, managing SSO, marketplace integration, and ML observability. Triggers: "Weights and Biases", "W&B", "WeightsAndBiases", "ML experiment tracking", "model registry", "experiment management", "wandb".

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-mgmt-weightsandbiases-dotnet/SKILL.md`

## `azure-microsoft-playwright-testing-ts`

**In chat:** `/azure-microsoft-playwright-testing-ts`

Run Playwright tests at scale using Azure Playwright Workspaces (formerly Microsoft Playwright Testing). Use when scaling browser tests across cloud-hosted browsers, integrating with CI/CD pipelines, or publishing test results to the Azure portal.

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-microsoft-playwright-testing-ts/SKILL.md`

## `azure-monitor-ingestion-java`

**In chat:** `/azure-monitor-ingestion-java`

Azure Monitor Ingestion SDK for Java. Send custom logs to Azure Monitor via Data Collection Rules (DCR) and Data Collection Endpoints (DCE). Triggers: "LogsIngestionClient java", "azure monitor ingestion java", "custom logs java", "DCR java", "data collection rule java".

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-monitor-ingestion-java/SKILL.md`

## `azure-monitor-ingestion-py`

**In chat:** `/azure-monitor-ingestion-py`

Azure Monitor Ingestion SDK for Python. Use for sending custom logs to Log Analytics workspace via Logs Ingestion API. Triggers: "azure-monitor-ingestion", "LogsIngestionClient", "custom logs", "DCR", "data collection rule", "Log Analytics".

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-monitor-ingestion-py/SKILL.md`

## `azure-monitor-opentelemetry-exporter-java`

**In chat:** `/azure-monitor-opentelemetry-exporter-java`

Azure Monitor OpenTelemetry Exporter for Java. Export OpenTelemetry traces, metrics, and logs to Azure Monitor/Application Insights. Triggers: "AzureMonitorExporter java", "opentelemetry azure java", "application insights java otel", "azure monitor tracing java". Note: This package is DEPRECATED. Migrate to azure-monitor-opentelemetry-autoconfigure.

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-monitor-opentelemetry-exporter-java/SKILL.md`

## `azure-monitor-opentelemetry-exporter-py`

**In chat:** `/azure-monitor-opentelemetry-exporter-py`

Azure Monitor OpenTelemetry Exporter for Python. Use for low-level OpenTelemetry export to Application Insights. Triggers: "azure-monitor-opentelemetry-exporter", "AzureMonitorTraceExporter", "AzureMonitorMetricExporter", "AzureMonitorLogExporter".

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-monitor-opentelemetry-exporter-py/SKILL.md`

## `azure-monitor-opentelemetry-py`

**In chat:** `/azure-monitor-opentelemetry-py`

Azure Monitor OpenTelemetry Distro for Python. Use for one-line Application Insights setup with auto-instrumentation. Triggers: "azure-monitor-opentelemetry", "configure_azure_monitor", "Application Insights", "OpenTelemetry distro", "auto-instrumentation".

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-monitor-opentelemetry-py/SKILL.md`

## `azure-monitor-opentelemetry-ts`

**In chat:** `/azure-monitor-opentelemetry-ts`

Instrument applications with Azure Monitor and OpenTelemetry for JavaScript (@azure/monitor-opentelemetry). Use when adding distributed tracing, metrics, and logs to Node.js applications with Application Insights.

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-monitor-opentelemetry-ts/SKILL.md`

## `azure-monitor-query-java`

**In chat:** `/azure-monitor-query-java`

Azure Monitor Query SDK for Java. Execute Kusto queries against Log Analytics workspaces and query metrics from Azure resources. Triggers: "LogsQueryClient java", "MetricsQueryClient java", "kusto query java", "log analytics java", "azure monitor query java". Note: This package is deprecated. Migrate to azure-monitor-query-logs and azure-monitor-query-metrics.

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-monitor-query-java/SKILL.md`

## `azure-monitor-query-py`

**In chat:** `/azure-monitor-query-py`

Azure Monitor Query SDK for Python. Use for querying Log Analytics workspaces and Azure Monitor metrics. Triggers: "azure-monitor-query", "LogsQueryClient", "MetricsQueryClient", "Log Analytics", "Kusto queries", "Azure metrics".

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-monitor-query-py/SKILL.md`

## `azure-postgres-ts`

**In chat:** `/azure-postgres-ts`

Connect to Azure Database for PostgreSQL Flexible Server from Node.js/TypeScript using the pg (node-postgres) package. Use for PostgreSQL queries, connection pooling, transactions, and Microsoft Entra ID (passwordless) authentication. Triggers: "PostgreSQL", "postgres", "pg client", "node-postgres", "Azure PostgreSQL connection", "PostgreSQL TypeScript", "pg Pool", "passwordless postgres".

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-postgres-ts/SKILL.md`

## `azure-resource-manager-cosmosdb-dotnet`

**In chat:** `/azure-resource-manager-cosmosdb-dotnet`

Azure Resource Manager SDK for Cosmos DB in .NET. Use for MANAGEMENT PLANE operations: creating/managing Cosmos DB accounts, databases, containers, throughput settings, and RBAC via Azure Resource Manager. NOT for data plane operations (CRUD on documents) - use Microsoft.Azure.Cosmos for that. Triggers: "Cosmos DB account", "create Cosmos account", "manage Cosmos resources", "ARM Cosmos", "CosmosDBAccountResource", "provision Cosmos DB".

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-resource-manager-cosmosdb-dotnet/SKILL.md`

## `azure-resource-manager-durabletask-dotnet`

**In chat:** `/azure-resource-manager-durabletask-dotnet`

Azure Resource Manager SDK for Durable Task Scheduler in .NET. Use for MANAGEMENT PLANE operations: creating/managing Durable Task Schedulers, Task Hubs, and retention policies via Azure Resource Manager. Triggers: "Durable Task Scheduler", "create scheduler", "task hub", "DurableTaskSchedulerResource", "provision Durable Task", "orchestration scheduler".

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-resource-manager-durabletask-dotnet/SKILL.md`

## `azure-resource-manager-mysql-dotnet`

**In chat:** `/azure-resource-manager-mysql-dotnet`

Azure MySQL Flexible Server SDK for .NET. Database management for MySQL Flexible Server deployments. Use for creating servers, databases, firewall rules, configurations, backups, and high availability. Triggers: "MySQL", "MySqlFlexibleServer", "MySQL Flexible Server", "Azure Database for MySQL", "MySQL database management", "MySQL firewall", "MySQL backup".

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-resource-manager-mysql-dotnet/SKILL.md`

## `azure-resource-manager-playwright-dotnet`

**In chat:** `/azure-resource-manager-playwright-dotnet`

Azure Resource Manager SDK for Microsoft Playwright Testing in .NET. Use for MANAGEMENT PLANE operations: creating/managing Playwright Testing workspaces, checking name availability, and managing workspace quotas via Azure Resource Manager. NOT for running Playwright tests - use Azure.Developer.MicrosoftPlaywrightTesting.NUnit for that. Triggers: "Playwright workspace", "create Playwright Testing workspace", "manage Playwright resources", "ARM Playwright", "PlaywrightWorkspaceResource", "provision Playwright Testing".

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-resource-manager-playwright-dotnet/SKILL.md`

## `azure-resource-manager-postgresql-dotnet`

**In chat:** `/azure-resource-manager-postgresql-dotnet`

Azure PostgreSQL Flexible Server SDK for .NET. Database management for PostgreSQL Flexible Server deployments. Use for creating servers, databases, firewall rules, configurations, backups, and high availability. Triggers: "PostgreSQL", "PostgreSqlFlexibleServer", "PostgreSQL Flexible Server", "Azure Database for PostgreSQL", "PostgreSQL database management", "PostgreSQL firewall", "PostgreSQL backup", "Postgres".

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-resource-manager-postgresql-dotnet/SKILL.md`

## `azure-resource-manager-redis-dotnet`

**In chat:** `/azure-resource-manager-redis-dotnet`

Azure Resource Manager SDK for Redis in .NET. Use for MANAGEMENT PLANE operations: creating/managing Azure Cache for Redis instances, firewall rules, access keys, patch schedules, linked servers (geo-replication), and private endpoints via Azure Resource Manager. NOT for data plane operations (get/set keys, pub/sub) - use StackExchange.Redis for that. Triggers: "Redis cache", "create Redis", "manage Redis", "ARM Redis", "RedisResource", "provision Redis", "Azure Cache for Redis".

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-resource-manager-redis-dotnet/SKILL.md`

## `azure-resource-manager-sql-dotnet`

**In chat:** `/azure-resource-manager-sql-dotnet`

Azure Resource Manager SDK for Azure SQL in .NET. Use for MANAGEMENT PLANE operations: creating/managing SQL servers, databases, elastic pools, firewall rules, and failover groups via Azure Resource Manager. NOT for data plane operations (executing queries) - use Microsoft.Data.SqlClient for that. Triggers: "SQL server", "create SQL database", "manage SQL resources", "ARM SQL", "SqlServerResource", "provision Azure SQL", "elastic pool", "firewall rule".

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-resource-manager-sql-dotnet/SKILL.md`

## `azure-search-documents-dotnet`

**In chat:** `/azure-search-documents-dotnet`

Azure AI Search SDK for .NET (Azure.Search.Documents). Use for building search applications with full-text, vector, semantic, and hybrid search. Covers SearchClient (queries, document CRUD), SearchIndexClient (index management), and SearchIndexerClient (indexers, skillsets). Triggers: "Azure Search .NET", "SearchClient", "SearchIndexClient", "vector search C#", "semantic search .NET", "hybrid search", "Azure.Search.Documents".

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-search-documents-dotnet/SKILL.md`

## `azure-search-documents-py`

**In chat:** `/azure-search-documents-py`

Azure AI Search SDK for Python. Use for vector search, hybrid search, semantic ranking, indexing, and skillsets. Triggers: "azure-search-documents", "SearchClient", "SearchIndexClient", "vector search", "hybrid search", "semantic search".

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-search-documents-py/SKILL.md`

## `azure-search-documents-ts`

**In chat:** `/azure-search-documents-ts`

Build search applications using Azure AI Search SDK for JavaScript (@azure/search-documents). Use when creating/managing indexes, implementing vector/hybrid search, semantic ranking, or building agentic retrieval with knowledge bases.

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-search-documents-ts/SKILL.md`

## `azure-security-keyvault-keys-dotnet`

**In chat:** `/azure-security-keyvault-keys-dotnet`

Azure Key Vault Keys SDK for .NET. Client library for managing cryptographic keys in Azure Key Vault and Managed HSM. Use for key creation, rotation, encryption, decryption, signing, and verification. Triggers: "Key Vault keys", "KeyClient", "CryptographyClient", "RSA key", "EC key", "encrypt decrypt .NET", "key rotation", "HSM".

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-security-keyvault-keys-dotnet/SKILL.md`

## `azure-security-keyvault-keys-java`

**In chat:** `/azure-security-keyvault-keys-java`

Azure Key Vault Keys Java SDK for cryptographic key management. Use when creating, managing, or using RSA/EC keys, performing encrypt/decrypt/sign/verify operations, or working with HSM-backed keys.

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-security-keyvault-keys-java/SKILL.md`

## `azure-security-keyvault-secrets-java`

**In chat:** `/azure-security-keyvault-secrets-java`

Azure Key Vault Secrets Java SDK for secret management. Use when storing, retrieving, or managing passwords, API keys, connection strings, or other sensitive configuration data.

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-security-keyvault-secrets-java/SKILL.md`

## `azure-servicebus-dotnet`

**In chat:** `/azure-servicebus-dotnet`

Azure Service Bus SDK for .NET. Enterprise messaging with queues, topics, subscriptions, and sessions. Use for reliable message delivery, pub/sub patterns, dead letter handling, and background processing. Triggers: "Service Bus", "ServiceBusClient", "ServiceBusSender", "ServiceBusReceiver", "ServiceBusProcessor", "message queue", "pub/sub .NET", "dead letter queue".

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-servicebus-dotnet/SKILL.md`

## `azure-servicebus-py`

**In chat:** `/azure-servicebus-py`

Azure Service Bus SDK for Python messaging. Use for queues, topics, subscriptions, and enterprise messaging patterns. Triggers: "service bus", "ServiceBusClient", "queue", "topic", "subscription", "message broker".

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-servicebus-py/SKILL.md`

## `azure-servicebus-ts`

**In chat:** `/azure-servicebus-ts`

Build messaging applications using Azure Service Bus SDK for JavaScript (@azure/service-bus). Use when implementing queues, topics/subscriptions, message sessions, dead-letter handling, or enterprise messaging patterns.

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-servicebus-ts/SKILL.md`

## `azure-speech-to-text-rest-py`

**In chat:** `/azure-speech-to-text-rest-py`

Azure Speech to Text REST API for short audio (Python). Use for simple speech recognition of audio files up to 60 seconds without the Speech SDK. Triggers: "speech to text REST", "short audio transcription", "speech recognition REST API", "STT REST", "recognize speech REST". DO NOT USE FOR: Long audio (>60 seconds), real-time streaming, batch transcription, custom speech models, speech translation. Use Speech SDK or Batch Transcription API instead.

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-speech-to-text-rest-py/SKILL.md`

## `azure-storage-blob-java`

**In chat:** `/azure-storage-blob-java`

Build blob storage applications with Azure Storage Blob SDK for Java. Use when uploading, downloading, or managing files in Azure Blob Storage, working with containers, or implementing streaming data operations.

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-storage-blob-java/SKILL.md`

## `azure-storage-blob-py`

**In chat:** `/azure-storage-blob-py`

Azure Blob Storage SDK for Python. Use for uploading, downloading, listing blobs, managing containers, and blob lifecycle. Triggers: "blob storage", "BlobServiceClient", "ContainerClient", "BlobClient", "upload blob", "download blob".

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-storage-blob-py/SKILL.md`

## `azure-storage-blob-rust`

**In chat:** `/azure-storage-blob-rust`

Azure Blob Storage SDK for Rust. Use for uploading, downloading, and managing blobs and containers. Triggers: "blob storage rust", "BlobClient rust", "upload blob rust", "download blob rust", "container rust".

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-storage-blob-rust/SKILL.md`

## `azure-storage-blob-ts`

**In chat:** `/azure-storage-blob-ts`

Azure Blob Storage JavaScript/TypeScript SDK (@azure/storage-blob) for blob operations. Use for uploading, downloading, listing, and managing blobs and containers. Supports block blobs, append blobs, page blobs, SAS tokens, and streaming. Triggers: "blob storage", "@azure/storage-blob", "BlobServiceClient", "ContainerClient", "upload blob", "download blob", "SAS token", "block blob".

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-storage-blob-ts/SKILL.md`

## `azure-storage-file-datalake-py`

**In chat:** `/azure-storage-file-datalake-py`

Azure Data Lake Storage Gen2 SDK for Python. Use for hierarchical file systems, big data analytics, and file/directory operations. Triggers: "data lake", "DataLakeServiceClient", "FileSystemClient", "ADLS Gen2", "hierarchical namespace".

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-storage-file-datalake-py/SKILL.md`

## `azure-storage-file-share-py`

**In chat:** `/azure-storage-file-share-py`

Azure Storage File Share SDK for Python. Use for SMB file shares, directories, and file operations in the cloud. Triggers: "azure-storage-file-share", "ShareServiceClient", "ShareClient", "file share", "SMB".

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-storage-file-share-py/SKILL.md`

## `azure-storage-file-share-ts`

**In chat:** `/azure-storage-file-share-ts`

Azure File Share JavaScript/TypeScript SDK (@azure/storage-file-share) for SMB file share operations. Use for creating shares, managing directories, uploading/downloading files, and handling file metadata. Supports Azure Files SMB protocol scenarios. Triggers: "file share", "@azure/storage-file-share", "ShareServiceClient", "ShareClient", "SMB", "Azure Files".

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-storage-file-share-ts/SKILL.md`

## `azure-storage-queue-py`

**In chat:** `/azure-storage-queue-py`

Azure Queue Storage SDK for Python. Use for reliable message queuing, task distribution, and asynchronous processing. Triggers: "queue storage", "QueueServiceClient", "QueueClient", "message queue", "dequeue".

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-storage-queue-py/SKILL.md`

## `azure-storage-queue-ts`

**In chat:** `/azure-storage-queue-ts`

Azure Queue Storage JavaScript/TypeScript SDK (@azure/storage-queue) for message queue operations. Use for sending, receiving, peeking, and deleting messages in queues. Supports visibility timeout, message encoding, and batch operations. Triggers: "queue storage", "@azure/storage-queue", "QueueServiceClient", "QueueClient", "send message", "receive message", "dequeue", "visibility timeout".

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-storage-queue-ts/SKILL.md`

## `azure-web-pubsub-ts`

**In chat:** `/azure-web-pubsub-ts`

Build real-time messaging applications using Azure Web PubSub SDKs for JavaScript (@azure/web-pubsub, @azure/web-pubsub-client). Use when implementing WebSocket-based real-time features, pub/sub messaging, group chat, or live notifications.

*Source:* `/Users/elliesmith/.cursor/skills/skills/azure-web-pubsub-ts/SKILL.md`

## `babysit`

**In chat:** `/babysit`

Keep a PR merge-ready by triaging comments, resolving clear conflicts, and fixing CI in a loop.

*Source:* `/Users/elliesmith/.cursor/skills-cursor/babysit/SKILL.md`

## `backend-architect`

**In chat:** `/backend-architect`

Expert backend architect specializing in scalable API design, microservices architecture, and distributed systems. Masters REST/GraphQL/gRPC APIs, event-driven architectures, service mesh patterns, and modern backend frameworks. Handles service boundary definition, inter-service communication, resilience patterns, and observability. Use PROACTIVELY when creating new backend services or APIs.

*Source:* `/Users/elliesmith/.cursor/skills/skills/backend-architect/SKILL.md`

## `backend-dev-guidelines`

**In chat:** `/backend-dev-guidelines`

Opinionated backend development standards for Node.js + Express + TypeScript microservices. Covers layered architecture, BaseController pattern, dependency injection, Prisma repositories, Zod validation, unifiedConfig, Sentry error tracking, async safety, and testing discipline.

*Source:* `/Users/elliesmith/.cursor/skills/skills/backend-dev-guidelines/SKILL.md`

## `backend-development-feature-development`

**In chat:** `/backend-development-feature-development`

"Orchestrate end-to-end backend feature development from requirements to deployment. Use when coordinating multi-phase feature delivery across teams and services."

*Source:* `/Users/elliesmith/.cursor/skills/skills/backend-development-feature-development/SKILL.md`

## `backend-patterns`

**In chat:** `/cc-skill-backend-patterns`

Backend architecture patterns, API design, database optimization, and server-side best practices for Node.js, Express, and Next.js API routes.

*Source:* `/Users/elliesmith/.cursor/skills/skills/cc-skill-backend-patterns/SKILL.md`

## `backend-security-coder`

**In chat:** `/backend-security-coder`

Expert in secure backend coding practices specializing in input validation, authentication, and API security. Use PROACTIVELY for backend security implementations or security code reviews.

*Source:* `/Users/elliesmith/.cursor/skills/skills/backend-security-coder/SKILL.md`

## `backtesting-frameworks`

**In chat:** `/backtesting-frameworks`

Build robust backtesting systems for trading strategies with proper handling of look-ahead bias, survivorship bias, and transaction costs. Use when developing trading algorithms, validating strategies, or building backtesting infrastructure.

*Source:* `/Users/elliesmith/.cursor/skills/skills/backtesting-frameworks/SKILL.md`

## `bamboohr-automation`

**In chat:** `/bamboohr-automation`

"Automate BambooHR tasks via Rube MCP (Composio): employees, time-off, benefits, dependents, employee updates. Always search tools first for current schemas."

*Source:* `/Users/elliesmith/.cursor/skills/skills/bamboohr-automation/SKILL.md`

## `basecamp-automation`

**In chat:** `/basecamp-automation`

"Automate Basecamp project management, to-dos, messages, people, and to-do list organization via Rube MCP (Composio). Always search tools first for current schemas."

*Source:* `/Users/elliesmith/.cursor/skills/skills/basecamp-automation/SKILL.md`

## `bash-defensive-patterns`

**In chat:** `/bash-defensive-patterns`

Master defensive Bash programming techniques for production-grade scripts. Use when writing robust shell scripts, CI/CD pipelines, or system utilities requiring fault tolerance and safety.

*Source:* `/Users/elliesmith/.cursor/skills/skills/bash-defensive-patterns/SKILL.md`

## `bash-linux`

**In chat:** `/bash-linux`

Bash/Linux terminal patterns. Critical commands, piping, error handling, scripting. Use when working on macOS or Linux systems.

*Source:* `/Users/elliesmith/.cursor/skills/skills/bash-linux/SKILL.md`

## `bash-pro`

**In chat:** `/bash-pro`

Master of defensive Bash scripting for production automation, CI/CD pipelines, and system utilities. Expert in safe, portable, and testable shell scripts.

*Source:* `/Users/elliesmith/.cursor/skills/skills/bash-pro/SKILL.md`

## `bats-testing-patterns`

**In chat:** `/bats-testing-patterns`

Master Bash Automated Testing System (Bats) for comprehensive shell script testing. Use when writing tests for shell scripts, CI/CD pipelines, or requiring test-driven development of shell utilities.

*Source:* `/Users/elliesmith/.cursor/skills/skills/bats-testing-patterns/SKILL.md`

## `bazel-build-optimization`

**In chat:** `/bazel-build-optimization`

Optimize Bazel builds for large-scale monorepos. Use when configuring Bazel, implementing remote execution, or optimizing build performance for enterprise codebases.

*Source:* `/Users/elliesmith/.cursor/skills/skills/bazel-build-optimization/SKILL.md`

## `beautiful-prose`

**In chat:** `/beautiful-prose`

"Hard-edged writing style contract for timeless, forceful English prose without AI tics"

*Source:* `/Users/elliesmith/.cursor/skills/skills/beautiful-prose/SKILL.md`

## `behavioral-modes`

**In chat:** `/behavioral-modes`

AI operational modes (brainstorm, implement, debug, review, teach, ship, orchestrate). Use to adapt behavior based on task type.

*Source:* `/Users/elliesmith/.cursor/skills/skills/behavioral-modes/SKILL.md`

## `billing-automation`

**In chat:** `/billing-automation`

Build automated billing systems for recurring payments, invoicing, subscription lifecycle, and dunning management. Use when implementing subscription billing, automating invoicing, or managing recurring payment systems.

*Source:* `/Users/elliesmith/.cursor/skills/skills/billing-automation/SKILL.md`

## `binary-analysis-patterns`

**In chat:** `/binary-analysis-patterns`

Master binary analysis patterns including disassembly, decompilation, control flow analysis, and code pattern recognition. Use when analyzing executables, understanding compiled code, or performing static analysis on binaries.

*Source:* `/Users/elliesmith/.cursor/skills/skills/binary-analysis-patterns/SKILL.md`

## `bitbucket-automation`

**In chat:** `/bitbucket-automation`

"Automate Bitbucket repositories, pull requests, branches, issues, and workspace management via Rube MCP (Composio). Always search tools first for current schemas."

*Source:* `/Users/elliesmith/.cursor/skills/skills/bitbucket-automation/SKILL.md`

## `blockchain-developer`

**In chat:** `/blockchain-developer`

Build production-ready Web3 applications, smart contracts, and decentralized systems. Implements DeFi protocols, NFT platforms, DAOs, and enterprise blockchain integrations. Use PROACTIVELY for smart contracts, Web3 apps, DeFi protocols, or blockchain infrastructure.

*Source:* `/Users/elliesmith/.cursor/skills/skills/blockchain-developer/SKILL.md`

## `blockrun`

**In chat:** `/blockrun`

Use when user needs capabilities Claude lacks (image generation, real-time X/Twitter data) or explicitly requests external models ("blockrun", "use grok", "use gpt", "dall-e", "deepseek")

*Source:* `/Users/elliesmith/.cursor/skills/skills/blockrun/SKILL.md`

## `box-automation`

**In chat:** `/box-automation`

"Automate Box cloud storage operations including file upload/download, search, folder management, sharing, collaborations, and metadata queries via Rube MCP (Composio). Always search tools first for current schemas."

*Source:* `/Users/elliesmith/.cursor/skills/skills/box-automation/SKILL.md`

## `brainstorming`

**In chat:** `/brainstorming`

Use this skill before any creative or constructive work (features, components, architecture, behavior changes, or functionality). This skill transforms vague ideas into validated designs through disciplined, incremental reasoning and collaboration.

*Source:* `/Users/elliesmith/.cursor/skills/skills/brainstorming/SKILL.md`

## `brand-guidelines`

**In chat:** `/brand-guidelines-anthropic`

Applies Anthropic's official brand colors and typography to any sort of artifact that may benefit from having Anthropic's look-and-feel. Use it when brand colors or style guidelines, visual formatting, or company design standards apply.

*Source:* `/Users/elliesmith/.cursor/skills/skills/brand-guidelines-anthropic/SKILL.md`

## `brevo-automation`

**In chat:** `/brevo-automation`

"Automate Brevo (Sendinblue) tasks via Rube MCP (Composio): manage email campaigns, create/edit templates, track senders, and monitor campaign performance. Always search tools first for current schemas."

*Source:* `/Users/elliesmith/.cursor/skills/skills/brevo-automation/SKILL.md`

## `Broken Authentication Testing`

**In chat:** `/broken-authentication`

This skill should be used when the user asks to "test for broken authentication vulnerabilities", "assess session management security", "perform credential stuffing tests", "evaluate password policies", "test for session fixation", or "identify authentication bypass flaws". It provides comprehensive techniques for identifying authentication and session management weaknesses in web applications.

*Source:* `/Users/elliesmith/.cursor/skills/skills/broken-authentication/SKILL.md`

## `browser-automation`

**In chat:** `/browser-automation`

"Browser automation powers web testing, scraping, and AI agent interactions. The difference between a flaky script and a reliable system comes down to understanding selectors, waiting strategies, and anti-detection patterns. This skill covers Playwright (recommended) and Puppeteer, with patterns for testing, scraping, and agentic browser control. Key insight: Playwright won the framework war. Unless you need Puppeteer's stealth ecosystem or are Chrome-only, Playwright is the better choice in 202"

*Source:* `/Users/elliesmith/.cursor/skills/skills/browser-automation/SKILL.md`

## `browser-extension-builder`

**In chat:** `/browser-extension-builder`

"Expert in building browser extensions that solve real problems - Chrome, Firefox, and cross-browser extensions. Covers extension architecture, manifest v3, content scripts, popup UIs, monetization strategies, and Chrome Web Store publishing. Use when: browser extension, chrome extension, firefox addon, extension, manifest v3."

*Source:* `/Users/elliesmith/.cursor/skills/skills/browser-extension-builder/SKILL.md`

## `bullmq-specialist`

**In chat:** `/bullmq-specialist`

"BullMQ expert for Redis-backed job queues, background processing, and reliable async execution in Node.js/TypeScript applications. Use when: bullmq, bull queue, redis queue, background job, job queue."

*Source:* `/Users/elliesmith/.cursor/skills/skills/bullmq-specialist/SKILL.md`

## `bun-development`

**In chat:** `/bun-development`

"Modern JavaScript/TypeScript development with Bun runtime. Covers package management, bundling, testing, and migration from Node.js. Use when working with Bun, optimizing JS/TS development speed, or migrating from Node.js to Bun."

*Source:* `/Users/elliesmith/.cursor/skills/skills/bun-development/SKILL.md`

## `Burp Suite Web Application Testing`

**In chat:** `/burp-suite-testing`

This skill should be used when the user asks to "intercept HTTP traffic", "modify web requests", "use Burp Suite for testing", "perform web vulnerability scanning", "test with Burp Repeater", "analyze HTTP history", or "configure proxy for web testing". It provides comprehensive guidance for using Burp Suite's core features for web application security testing.

*Source:* `/Users/elliesmith/.cursor/skills/skills/burp-suite-testing/SKILL.md`

## `business-analyst`

**In chat:** `/business-analyst`

Master modern business analysis with AI-powered analytics, real-time dashboards, and data-driven insights. Build comprehensive KPI frameworks, predictive models, and strategic recommendations. Use PROACTIVELY for business intelligence or strategic analysis.

*Source:* `/Users/elliesmith/.cursor/skills/skills/business-analyst/SKILL.md`

## `busybox-on-windows`

**In chat:** `/busybox-on-windows`

How to use a Win32 build of BusyBox to run many of the standard UNIX command line tools on Windows.

*Source:* `/Users/elliesmith/.cursor/skills/skills/busybox-on-windows/SKILL.md`

## `c-pro`

**In chat:** `/c-pro`

Write efficient C code with proper memory management, pointer arithmetic, and system calls. Handles embedded systems, kernel modules, and performance-critical code. Use PROACTIVELY for C optimization, memory issues, or system programming.

*Source:* `/Users/elliesmith/.cursor/skills/skills/c-pro/SKILL.md`

## `c4-architecture-c4-architecture`

**In chat:** `/c4-architecture-c4-architecture`

"Generate comprehensive C4 architecture documentation for an existing repository/codebase using a bottom-up analysis approach."

*Source:* `/Users/elliesmith/.cursor/skills/skills/c4-architecture-c4-architecture/SKILL.md`

## `c4-code`

**In chat:** `/c4-code`

Expert C4 Code-level documentation specialist. Analyzes code directories to create comprehensive C4 code-level documentation including function signatures, arguments, dependencies, and code structure. Use when documenting code at the lowest C4 level for individual directories and code modules.

*Source:* `/Users/elliesmith/.cursor/skills/skills/c4-code/SKILL.md`

## `c4-component`

**In chat:** `/c4-component`

Expert C4 Component-level documentation specialist. Synthesizes C4 Code-level documentation into Component-level architecture, defining component boundaries, interfaces, and relationships. Creates component diagrams and documentation. Use when synthesizing code-level documentation into logical components.

*Source:* `/Users/elliesmith/.cursor/skills/skills/c4-component/SKILL.md`

## `c4-container`

**In chat:** `/c4-container`

Expert C4 Container-level documentation specialist. Synthesizes Component-level documentation into Container-level architecture, mapping components to deployment units, documenting container interfaces as APIs, and creating container diagrams. Use when synthesizing components into deployment containers and documenting system deployment architecture.

*Source:* `/Users/elliesmith/.cursor/skills/skills/c4-container/SKILL.md`

## `c4-context`

**In chat:** `/c4-context`

Expert C4 Context-level documentation specialist. Creates high-level system context diagrams, documents personas, user journeys, system features, and external dependencies. Synthesizes container and component documentation with system documentation to create comprehensive context-level architecture. Use when creating the highest-level C4 system context documentation.

*Source:* `/Users/elliesmith/.cursor/skills/skills/c4-context/SKILL.md`

## `cal-com-automation`

**In chat:** `/cal-com-automation`

"Automate Cal.com tasks via Rube MCP (Composio): manage bookings, check availability, configure webhooks, and handle teams. Always search tools first for current schemas."

*Source:* `/Users/elliesmith/.cursor/skills/skills/cal-com-automation/SKILL.md`

## `calendly-automation`

**In chat:** `/calendly-automation`

"Automate Calendly scheduling, event management, invitee tracking, availability checks, and organization administration via Rube MCP (Composio). Always search tools first for current schemas."

*Source:* `/Users/elliesmith/.cursor/skills/skills/calendly-automation/SKILL.md`

## `canva-automation`

**In chat:** `/canva-automation`

"Automate Canva tasks via Rube MCP (Composio): designs, exports, folders, brand templates, autofill. Always search tools first for current schemas."

*Source:* `/Users/elliesmith/.cursor/skills/skills/canva-automation/SKILL.md`

## `canvas-design`

**In chat:** `/canvas-design`

Create beautiful visual art in .png and .pdf documents using design philosophy. You should use this skill when the user asks to create a poster, piece of art, design, or other static piece. Create original visual designs, never copying existing artists' work to avoid copyright violations.

*Source:* `/Users/elliesmith/.cursor/skills/skills/canvas-design/SKILL.md`

## `cc-skill-continuous-learning`

**In chat:** `/cc-skill-continuous-learning`

Development skill from everything-claude-code

*Source:* `/Users/elliesmith/.cursor/skills/skills/cc-skill-continuous-learning/SKILL.md`

## `cc-skill-project-guidelines-example`

**In chat:** `/cc-skill-project-guidelines-example`

Project Guidelines Skill (Example)

*Source:* `/Users/elliesmith/.cursor/skills/skills/cc-skill-project-guidelines-example/SKILL.md`

## `cc-skill-strategic-compact`

**In chat:** `/cc-skill-strategic-compact`

Development skill from everything-claude-code

*Source:* `/Users/elliesmith/.cursor/skills/skills/cc-skill-strategic-compact/SKILL.md`

## `changelog-automation`

**In chat:** `/changelog-automation`

Automate changelog generation from commits, PRs, and releases following Keep a Changelog format. Use when setting up release workflows, generating release notes, or standardizing commit conventions.

*Source:* `/Users/elliesmith/.cursor/skills/skills/changelog-automation/SKILL.md`

## `cicd-automation-workflow-automate`

**In chat:** `/cicd-automation-workflow-automate`

"You are a workflow automation expert specializing in creating efficient CI/CD pipelines, GitHub Actions workflows, and automated development processes. Design automation that reduces manual work, improves consistency, and accelerates delivery while maintaining quality and security."

*Source:* `/Users/elliesmith/.cursor/skills/skills/cicd-automation-workflow-automate/SKILL.md`

## `circleci-automation`

**In chat:** `/circleci-automation`

"Automate CircleCI tasks via Rube MCP (Composio): trigger pipelines, monitor workflows/jobs, retrieve artifacts and test metadata. Always search tools first for current schemas."

*Source:* `/Users/elliesmith/.cursor/skills/skills/circleci-automation/SKILL.md`

## `clarity-gate`

**In chat:** `/clarity-gate`

"Pre-ingestion verification for epistemic quality in RAG systems with 9-point verification and Two-Round HITL workflow"

*Source:* `/Users/elliesmith/.cursor/skills/skills/clarity-gate/SKILL.md`

## `Claude Code Guide`

**In chat:** `/claude-code-guide`

Master guide for using Claude Code effectively. Includes configuration templates, prompting strategies "Thinking" keywords, debugging techniques, and best practices for interacting with the agent.

*Source:* `/Users/elliesmith/.cursor/skills/skills/claude-code-guide/SKILL.md`

## `claude-ally-health`

**In chat:** `/claude-ally-health`

"A health assistant skill for medical information analysis, symptom tracking, and wellness guidance."

*Source:* `/Users/elliesmith/.cursor/skills/skills/claude-ally-health/SKILL.md`

## `claude-scientific-skills`

**In chat:** `/claude-scientific-skills`

"Scientific research and analysis skills"

*Source:* `/Users/elliesmith/.cursor/skills/skills/claude-scientific-skills/SKILL.md`

## `claude-speed-reader`

**In chat:** `/claude-speed-reader`

"-Speed read Claude's responses at 600+ WPM using RSVP with Spritz-style ORP highlighting"

*Source:* `/Users/elliesmith/.cursor/skills/skills/claude-speed-reader/SKILL.md`

## `claude-win11-speckit-update-skill`

**In chat:** `/claude-win11-speckit-update-skill`

"Windows 11 system management"

*Source:* `/Users/elliesmith/.cursor/skills/skills/claude-win11-speckit-update-skill/SKILL.md`

## `clean-code`

**In chat:** `/clean-code`

"Applies principles from Robert C. Martin's 'Clean Code'. Use this skill when writing, reviewing, or refactoring code to ensure high quality, readability, and maintainability. Covers naming, functions, comments, error handling, and class design."

*Source:* `/Users/elliesmith/.cursor/skills/skills/clean-code/SKILL.md`

## `clerk-auth`

**In chat:** `/clerk-auth`

"Expert patterns for Clerk auth implementation, middleware, organizations, webhooks, and user sync Use when: adding authentication, clerk auth, user authentication, sign in, sign up."

*Source:* `/Users/elliesmith/.cursor/skills/skills/clerk-auth/SKILL.md`

## `clickhouse-io`

**In chat:** `/cc-skill-clickhouse-io`

ClickHouse database patterns, query optimization, analytics, and data engineering best practices for high-performance analytical workloads.

*Source:* `/Users/elliesmith/.cursor/skills/skills/cc-skill-clickhouse-io/SKILL.md`

## `clickup-automation`

**In chat:** `/clickup-automation`

"Automate ClickUp project management including tasks, spaces, folders, lists, comments, and team operations via Rube MCP (Composio). Always search tools first for current schemas."

*Source:* `/Users/elliesmith/.cursor/skills/skills/clickup-automation/SKILL.md`

## `close-automation`

**In chat:** `/close-automation`

"Automate Close CRM tasks via Rube MCP (Composio): create leads, manage calls/SMS, handle tasks, and track notes. Always search tools first for current schemas."

*Source:* `/Users/elliesmith/.cursor/skills/skills/close-automation/SKILL.md`

## `Cloud Penetration Testing`

**In chat:** `/cloud-penetration-testing`

This skill should be used when the user asks to "perform cloud penetration testing", "assess Azure or AWS or GCP security", "enumerate cloud resources", "exploit cloud misconfigurations", "test O365 security", "extract secrets from cloud environments", or "audit cloud infrastructure". It provides comprehensive techniques for security assessment across major cloud platforms.

*Source:* `/Users/elliesmith/.cursor/skills/skills/cloud-penetration-testing/SKILL.md`

## `cloud-architect`

**In chat:** `/cloud-architect`

Expert cloud architect specializing in AWS/Azure/GCP multi-cloud infrastructure design, advanced IaC (Terraform/OpenTofu/CDK), FinOps cost optimization, and modern architectural patterns. Masters serverless, microservices, security, compliance, and disaster recovery. Use PROACTIVELY for cloud architecture, cost optimization, migration planning, or multi-cloud strategies.

*Source:* `/Users/elliesmith/.cursor/skills/skills/cloud-architect/SKILL.md`

## `coda-automation`

**In chat:** `/coda-automation`

"Automate Coda tasks via Rube MCP (Composio): manage docs, pages, tables, rows, formulas, permissions, and publishing. Always search tools first for current schemas."

*Source:* `/Users/elliesmith/.cursor/skills/skills/coda-automation/SKILL.md`

## `code-documentation-code-explain`

**In chat:** `/code-documentation-code-explain`

"You are a code education expert specializing in explaining complex code through clear narratives, visual diagrams, and step-by-step breakdowns. Transform difficult concepts into understandable explanations."

*Source:* `/Users/elliesmith/.cursor/skills/skills/code-documentation-code-explain/SKILL.md`

## `code-documentation-doc-generate`

**In chat:** `/code-documentation-doc-generate`

"You are a documentation expert specializing in creating comprehensive, maintainable documentation from code. Generate API docs, architecture diagrams, user guides, and technical references using AI-powered analysis and industry best practices."

*Source:* `/Users/elliesmith/.cursor/skills/skills/code-documentation-doc-generate/SKILL.md`

## `code-refactoring-context-restore`

**In chat:** `/code-refactoring-context-restore`

"Use when working with code refactoring context restore"

*Source:* `/Users/elliesmith/.cursor/skills/skills/code-refactoring-context-restore/SKILL.md`

## `code-refactoring-refactor-clean`

**In chat:** `/code-refactoring-refactor-clean`

"You are a code refactoring expert specializing in clean code principles, SOLID design patterns, and modern software engineering best practices. Analyze and refactor the provided code to improve its quality, maintainability, and performance."

*Source:* `/Users/elliesmith/.cursor/skills/skills/code-refactoring-refactor-clean/SKILL.md`

## `code-refactoring-tech-debt`

**In chat:** `/code-refactoring-tech-debt`

"You are a technical debt expert specializing in identifying, quantifying, and prioritizing technical debt in software projects. Analyze the codebase to uncover debt, assess its impact, and create acti"

*Source:* `/Users/elliesmith/.cursor/skills/skills/code-refactoring-tech-debt/SKILL.md`

## `code-review-ai-ai-review`

**In chat:** `/code-review-ai-ai-review`

"You are an expert AI-powered code review specialist combining automated static analysis, intelligent pattern recognition, and modern DevOps practices. Leverage AI tools (GitHub Copilot, Qodo, GPT-5, C"

*Source:* `/Users/elliesmith/.cursor/skills/skills/code-review-ai-ai-review/SKILL.md`

## `code-review-checklist`

**In chat:** `/code-review-checklist`

"Comprehensive checklist for conducting thorough code reviews covering functionality, security, performance, and maintainability"

*Source:* `/Users/elliesmith/.cursor/skills/skills/code-review-checklist/SKILL.md`

## `code-review-excellence`

**In chat:** `/code-review-excellence`

Master effective code review practices to provide constructive feedback, catch bugs early, and foster knowledge sharing while maintaining team morale. Use when reviewing pull requests, establishing review standards, or mentoring developers.

*Source:* `/Users/elliesmith/.cursor/skills/skills/code-review-excellence/SKILL.md`

## `code-reviewer`

**In chat:** `/code-reviewer`

Elite code review expert specializing in modern AI-powered code analysis, security vulnerabilities, performance optimization, and production reliability. Masters static analysis tools, security scanning, and configuration review with 2024/2025 best practices. Use PROACTIVELY for code quality assurance.

*Source:* `/Users/elliesmith/.cursor/skills/skills/code-reviewer/SKILL.md`

## `codebase-cleanup-deps-audit`

**In chat:** `/codebase-cleanup-deps-audit`

"You are a dependency security expert specializing in vulnerability scanning, license compliance, and supply chain security. Analyze project dependencies for known vulnerabilities, licensing issues, outdated packages, and provide actionable remediation strategies."

*Source:* `/Users/elliesmith/.cursor/skills/skills/codebase-cleanup-deps-audit/SKILL.md`

## `codebase-cleanup-refactor-clean`

**In chat:** `/codebase-cleanup-refactor-clean`

"You are a code refactoring expert specializing in clean code principles, SOLID design patterns, and modern software engineering best practices. Analyze and refactor the provided code to improve its quality, maintainability, and performance."

*Source:* `/Users/elliesmith/.cursor/skills/skills/codebase-cleanup-refactor-clean/SKILL.md`

## `codebase-cleanup-tech-debt`

**In chat:** `/codebase-cleanup-tech-debt`

"You are a technical debt expert specializing in identifying, quantifying, and prioritizing technical debt in software projects. Analyze the codebase to uncover debt, assess its impact, and create acti"

*Source:* `/Users/elliesmith/.cursor/skills/skills/codebase-cleanup-tech-debt/SKILL.md`

## `codex-review`

**In chat:** `/codex-review`

Professional code review with auto CHANGELOG generation, integrated with Codex AI

*Source:* `/Users/elliesmith/.cursor/skills/skills/codex-review/SKILL.md`

## `coding-standards`

**In chat:** `/cc-skill-coding-standards`

Universal coding standards, best practices, and patterns for TypeScript, JavaScript, React, and Node.js development.

*Source:* `/Users/elliesmith/.cursor/skills/skills/cc-skill-coding-standards/SKILL.md`

## `commit`

**In chat:** `/commit`

"Create commit messages following Sentry conventions. Use when committing code changes, writing commit messages, or formatting git history. Follows conventional commits with Sentry-specific issue references."

*Source:* `/Users/elliesmith/.cursor/skills/skills/commit/SKILL.md`

## `competitive-landscape`

**In chat:** `/competitive-landscape`

This skill should be used when the user asks to "analyze competitors", "assess competitive landscape", "identify differentiation", "evaluate market positioning", "apply Porter's Five Forces", or requests competitive strategy analysis.

*Source:* `/Users/elliesmith/.cursor/skills/skills/competitive-landscape/SKILL.md`

## `competitor-alternatives`

**In chat:** `/competitor-alternatives`

"When the user wants to create competitor comparison or alternative pages for SEO and sales enablement. Also use when the user mentions 'alternative page,' 'vs page,' 'competitor comparison,' 'comparison page,' '[Product] vs [Product],' '[Product] alternative,' or 'competitive landing pages.' Covers four formats: singular alternative, plural alternatives, you vs competitor, and competitor vs competitor. Emphasizes deep research, modular content architecture, and varied section types beyond feature tables."

*Source:* `/Users/elliesmith/.cursor/skills/skills/competitor-alternatives/SKILL.md`

## `comprehensive-review-full-review`

**In chat:** `/comprehensive-review-full-review`

"Use when working with comprehensive review full review"

*Source:* `/Users/elliesmith/.cursor/skills/skills/comprehensive-review-full-review/SKILL.md`

## `comprehensive-review-pr-enhance`

**In chat:** `/comprehensive-review-pr-enhance`

"You are a PR optimization expert specializing in creating high-quality pull requests that facilitate efficient code reviews. Generate comprehensive PR descriptions, automate review processes, and ensure PRs follow best practices for clarity, size, and reviewability."

*Source:* `/Users/elliesmith/.cursor/skills/skills/comprehensive-review-pr-enhance/SKILL.md`

## `computer-use-agents`

**In chat:** `/computer-use-agents`

"Build AI agents that interact with computers like humans do - viewing screens, moving cursors, clicking buttons, and typing text. Covers Anthropic's Computer Use, OpenAI's Operator/CUA, and open-source alternatives. Critical focus on sandboxing, security, and handling the unique challenges of vision-based control. Use when: computer use, desktop automation agent, screen control AI, vision-based agent, GUI automation."

*Source:* `/Users/elliesmith/.cursor/skills/skills/computer-use-agents/SKILL.md`

## `computer-vision-expert`

**In chat:** `/computer-vision-expert`

SOTA Computer Vision Expert (2026). Specialized in YOLO26, Segment Anything 3 (SAM 3), Vision Language Models, and real-time spatial analysis.

*Source:* `/Users/elliesmith/.cursor/skills/skills/computer-vision-expert/SKILL.md`

## `concise-planning`

**In chat:** `/concise-planning`

Use when a user asks for a plan for a coding task, to generate a clear, actionable, and atomic checklist.

*Source:* `/Users/elliesmith/.cursor/skills/skills/concise-planning/SKILL.md`

## `conductor-implement`

**In chat:** `/conductor-implement`

Execute tasks from a track's implementation plan following TDD workflow

*Source:* `/Users/elliesmith/.cursor/skills/skills/conductor-implement/SKILL.md`

## `conductor-manage`

**In chat:** `/conductor-manage`

"Manage track lifecycle: archive, restore, delete, rename, and cleanup"

*Source:* `/Users/elliesmith/.cursor/skills/skills/conductor-manage/SKILL.md`

## `conductor-new-track`

**In chat:** `/conductor-new-track`

Create a new track with specification and phased implementation plan

*Source:* `/Users/elliesmith/.cursor/skills/skills/conductor-new-track/SKILL.md`

## `conductor-revert`

**In chat:** `/conductor-revert`

Git-aware undo by logical work unit (track, phase, or task)

*Source:* `/Users/elliesmith/.cursor/skills/skills/conductor-revert/SKILL.md`

## `conductor-setup`

**In chat:** `/conductor-setup`

Initialize project with Conductor artifacts (product definition, tech stack, workflow, style guides)

*Source:* `/Users/elliesmith/.cursor/skills/skills/conductor-setup/SKILL.md`

## `conductor-status`

**In chat:** `/conductor-status`

Display project status, active tracks, and next actions

*Source:* `/Users/elliesmith/.cursor/skills/skills/conductor-status/SKILL.md`

## `conductor-validator`

**In chat:** `/conductor-validator`

Validates Conductor project artifacts for completeness, consistency, and correctness. Use after setup, when diagnosing issues, or before implementation to verify project context.

*Source:* `/Users/elliesmith/.cursor/skills/skills/conductor-validator/SKILL.md`

## `confluence-automation`

**In chat:** `/confluence-automation`

"Automate Confluence page creation, content search, space management, labels, and hierarchy navigation via Rube MCP (Composio). Always search tools first for current schemas."

*Source:* `/Users/elliesmith/.cursor/skills/skills/confluence-automation/SKILL.md`

## `content-creator`

**In chat:** `/content-creator`

Create SEO-optimized marketing content with consistent brand voice. Includes brand voice analyzer, SEO optimizer, content frameworks, and social media templates. Use when writing blog posts, creating social media content, analyzing brand voice, optimizing SEO, planning content calendars, or when user mentions content creation, brand voice, SEO optimization, social media marketing, or content strategy.

*Source:* `/Users/elliesmith/.cursor/skills/skills/content-creator/SKILL.md`

## `content-marketer`

**In chat:** `/content-marketer`

Elite content marketing strategist specializing in AI-powered content creation, omnichannel distribution, SEO optimization, and data-driven performance marketing. Masters modern content tools, social media automation, and conversion optimization with 2024/2025 best practices. Use PROACTIVELY for comprehensive content marketing.

*Source:* `/Users/elliesmith/.cursor/skills/skills/content-marketer/SKILL.md`

## `context-compression`

**In chat:** `/context-compression`

"Design and evaluate compression strategies for long-running sessions"

*Source:* `/Users/elliesmith/.cursor/skills/skills/context-compression/SKILL.md`

## `context-degradation`

**In chat:** `/context-degradation`

"Recognize patterns of context failure: lost-in-middle, poisoning, distraction, and clash"

*Source:* `/Users/elliesmith/.cursor/skills/skills/context-degradation/SKILL.md`

## `context-driven-development`

**In chat:** `/context-driven-development`

Use this skill when working with Conductor's context-driven development methodology, managing project context artifacts, or understanding the relationship between product.md, tech-stack.md, and workflow.md files.

*Source:* `/Users/elliesmith/.cursor/skills/skills/context-driven-development/SKILL.md`

## `context-fundamentals`

**In chat:** `/context-fundamentals`

"Understand what context is, why it matters, and the anatomy of context in agent systems"

*Source:* `/Users/elliesmith/.cursor/skills/skills/context-fundamentals/SKILL.md`

## `context-management-context-restore`

**In chat:** `/context-management-context-restore`

"Use when working with context management context restore"

*Source:* `/Users/elliesmith/.cursor/skills/skills/context-management-context-restore/SKILL.md`

## `context-management-context-save`

**In chat:** `/context-management-context-save`

"Use when working with context management context save"

*Source:* `/Users/elliesmith/.cursor/skills/skills/context-management-context-save/SKILL.md`

## `context-manager`

**In chat:** `/context-manager`

Elite AI context engineering specialist mastering dynamic context management, vector databases, knowledge graphs, and intelligent memory systems. Orchestrates context across multi-agent workflows, enterprise AI systems, and long-running projects with 2024/2025 best practices. Use PROACTIVELY for complex AI orchestration.

*Source:* `/Users/elliesmith/.cursor/skills/skills/context-manager/SKILL.md`

## `context-optimization`

**In chat:** `/context-optimization`

"Apply compaction, masking, and caching strategies"

*Source:* `/Users/elliesmith/.cursor/skills/skills/context-optimization/SKILL.md`

## `context-window-management`

**In chat:** `/context-window-management`

"Strategies for managing LLM context windows including summarization, trimming, routing, and avoiding context rot Use when: context window, token limit, context management, context engineering, long context."

*Source:* `/Users/elliesmith/.cursor/skills/skills/context-window-management/SKILL.md`

## `context7-auto-research`

**In chat:** `/context7-auto-research`

Automatically fetch latest library/framework documentation for Claude Code via Context7 API

*Source:* `/Users/elliesmith/.cursor/skills/skills/context7-auto-research/SKILL.md`

## `continual-learning`

**In chat:** `/continual-learning`

Orchestrate continual learning by delegating transcript mining and AGENTS.md updates to `agents-memory-updater`.

*Source:* `/Users/elliesmith/.cursor/plugins/cache/cursor-public/continual-learning/08c2bbe2ae8a022a21dc6c32faf611f14a6e8343/skills/continual-learning/SKILL.md`

## `conversation-memory`

**In chat:** `/conversation-memory`

"Persistent memory systems for LLM conversations including short-term, long-term, and entity-based memory Use when: conversation memory, remember, memory persistence, long-term memory, chat history."

*Source:* `/Users/elliesmith/.cursor/skills/skills/conversation-memory/SKILL.md`

## `convertkit-automation`

**In chat:** `/convertkit-automation`

"Automate ConvertKit (Kit) tasks via Rube MCP (Composio): manage subscribers, tags, broadcasts, and broadcast stats. Always search tools first for current schemas."

*Source:* `/Users/elliesmith/.cursor/skills/skills/convertkit-automation/SKILL.md`

## `copilot-sdk`

**In chat:** `/copilot-sdk`

Build applications powered by GitHub Copilot using the Copilot SDK. Use when creating programmatic integrations with Copilot across Node.js/TypeScript, Python, Go, or .NET. Covers session management, custom tools, streaming, hooks, MCP servers, BYOK providers, session persistence, and custom agents. Requires GitHub Copilot CLI installed and a GitHub Copilot subscription (unless using BYOK).

*Source:* `/Users/elliesmith/.cursor/skills/skills/copilot-sdk/SKILL.md`

## `copy-editing`

**In chat:** `/copy-editing`

"When the user wants to edit, review, or improve existing marketing copy. Also use when the user mentions 'edit this copy,' 'review my copy,' 'copy feedback,' 'proofread,' 'polish this,' 'make this better,' or 'copy sweep.' This skill provides a systematic approach to editing marketing copy through multiple focused passes."

*Source:* `/Users/elliesmith/.cursor/skills/skills/copy-editing/SKILL.md`

## `copywriting`

**In chat:** `/copywriting`

Use this skill when writing, rewriting, or improving marketing copy for any page (homepage, landing page, pricing, feature, product, or about page). This skill produces clear, compelling, and testable copy while enforcing alignment, honesty, and conversion best practices.

*Source:* `/Users/elliesmith/.cursor/skills/skills/copywriting/SKILL.md`

## `core-components`

**In chat:** `/core-components`

Core component library and design system patterns. Use when building UI, using design tokens, or working with the component library.

*Source:* `/Users/elliesmith/.cursor/skills/skills/core-components/SKILL.md`

## `cost-optimization`

**In chat:** `/cost-optimization`

Optimize cloud costs through resource rightsizing, tagging strategies, reserved instances, and spending analysis. Use when reducing cloud expenses, analyzing infrastructure costs, or implementing cost governance policies.

*Source:* `/Users/elliesmith/.cursor/skills/skills/cost-optimization/SKILL.md`

## `cpp-pro`

**In chat:** `/cpp-pro`

Write idiomatic C++ code with modern features, RAII, smart pointers, and STL algorithms. Handles templates, move semantics, and performance optimization. Use PROACTIVELY for C++ refactoring, memory safety, or complex C++ patterns.

*Source:* `/Users/elliesmith/.cursor/skills/skills/cpp-pro/SKILL.md`

## `cqrs-implementation`

**In chat:** `/cqrs-implementation`

Implement Command Query Responsibility Segregation for scalable architectures. Use when separating read and write models, optimizing query performance, or building event-sourced systems.

*Source:* `/Users/elliesmith/.cursor/skills/skills/cqrs-implementation/SKILL.md`

## `create-hook`

**In chat:** `/create-hook`

Create Cursor hooks. Use when you want to create a hook, write hooks.json, add hook scripts, or automate behavior around agent events.

*Source:* `/Users/elliesmith/.cursor/skills-cursor/create-hook/SKILL.md`

## `create-pr`

**In chat:** `/create-pr`

"Create pull requests following Sentry conventions. Use when opening PRs, writing PR descriptions, or preparing changes for review. Follows Sentry's code review guidelines."

*Source:* `/Users/elliesmith/.cursor/skills/skills/create-pr/SKILL.md`

## `create-rule`

**In chat:** `/create-rule`

Create Cursor rules for persistent AI guidance. Use when you want to create a rule, add coding standards, set up project conventions, configure file-specific patterns, create RULE.md files, or asks about .cursor/rules/ or AGENTS.md.

*Source:* `/Users/elliesmith/.cursor/skills-cursor/create-rule/SKILL.md`

## `create-skill`

**In chat:** `/create-skill`

Guides users through creating effective Agent Skills for Cursor. Use when you want to create, write, or author a new skill, or asks about skill structure, best practices, or SKILL.md format.

*Source:* `/Users/elliesmith/.cursor/skills-cursor/create-skill/SKILL.md`

## `create-subagent`

**In chat:** `/create-subagent`

Create custom subagents for specialized AI tasks. Use when you want to create a new type of subagent, set up task-specific agents, configure code reviewers, debuggers, or domain-specific assistants with custom prompts.

*Source:* `/Users/elliesmith/.cursor/skills-cursor/create-subagent/SKILL.md`

## `crewai`

**In chat:** `/crewai`

"Expert in CrewAI - the leading role-based multi-agent framework used by 60% of Fortune 500 companies. Covers agent design with roles and goals, task definition, crew orchestration, process types (sequential, hierarchical, parallel), memory systems, and flows for complex workflows. Essential for building collaborative AI agent teams. Use when: crewai, multi-agent team, agent roles, crew of agents, role-based agents."

*Source:* `/Users/elliesmith/.cursor/skills/skills/crewai/SKILL.md`

## `Cross-Site Scripting and HTML Injection Testing`

**In chat:** `/xss-html-injection`

This skill should be used when the user asks to "test for XSS vulnerabilities", "perform cross-site scripting attacks", "identify HTML injection flaws", "exploit client-side injection vulnerabilities", "steal cookies via XSS", or "bypass content security policies". It provides comprehensive techniques for detecting, exploiting, and understanding XSS and HTML injection attack vectors in web applications.

*Source:* `/Users/elliesmith/.cursor/skills/skills/xss-html-injection/SKILL.md`

## `csharp-pro`

**In chat:** `/csharp-pro`

Write modern C# code with advanced features like records, pattern matching, and async/await. Optimizes .NET applications, implements enterprise patterns, and ensures comprehensive testing. Use PROACTIVELY for C# refactoring, performance optimization, or complex .NET solutions.

*Source:* `/Users/elliesmith/.cursor/skills/skills/csharp-pro/SKILL.md`

## `culture-index`

**In chat:** `/culture-index`

"Index and search culture documentation"

*Source:* `/Users/elliesmith/.cursor/skills/skills/culture-index/SKILL.md`

## `customer-support`

**In chat:** `/customer-support`

Elite AI-powered customer support specialist mastering conversational AI, automated ticketing, sentiment analysis, and omnichannel support experiences. Integrates modern support tools, chatbot platforms, and CX optimization with 2024/2025 best practices. Use PROACTIVELY for comprehensive customer experience management.

*Source:* `/Users/elliesmith/.cursor/skills/skills/customer-support/SKILL.md`

## `d3-viz`

**In chat:** `/claude-d3js-skill`

Creating interactive data visualisations using d3.js. This skill should be used when creating custom charts, graphs, network diagrams, geographic visualisations, or any complex SVG-based data visualisation that requires fine-grained control over visual elements, transitions, or interactions. Use this for bespoke visualisations beyond standard charting libraries, whether in React, Vue, Svelte, vanilla JavaScript, or any other environment.

*Source:* `/Users/elliesmith/.cursor/skills/skills/claude-d3js-skill/SKILL.md`

## `daily-news-report`

**In chat:** `/daily-news-report`

Scrapes content based on a preset URL list, filters high-quality technical information, and generates daily Markdown reports.

*Source:* `/Users/elliesmith/.cursor/skills/skills/daily-news-report/SKILL.md`

## `data-engineer`

**In chat:** `/data-engineer`

Build scalable data pipelines, modern data warehouses, and real-time streaming architectures. Implements Apache Spark, dbt, Airflow, and cloud-native data platforms. Use PROACTIVELY for data pipeline design, analytics infrastructure, or modern data stack implementation.

*Source:* `/Users/elliesmith/.cursor/skills/skills/data-engineer/SKILL.md`

## `data-engineering-data-driven-feature`

**In chat:** `/data-engineering-data-driven-feature`

"Build features guided by data insights, A/B testing, and continuous measurement using specialized agents for analysis, implementation, and experimentation."

*Source:* `/Users/elliesmith/.cursor/skills/skills/data-engineering-data-driven-feature/SKILL.md`

## `data-engineering-data-pipeline`

**In chat:** `/data-engineering-data-pipeline`

"You are a data pipeline architecture expert specializing in scalable, reliable, and cost-effective data pipelines for batch and streaming data processing."

*Source:* `/Users/elliesmith/.cursor/skills/skills/data-engineering-data-pipeline/SKILL.md`

## `data-quality-frameworks`

**In chat:** `/data-quality-frameworks`

Implement data quality validation with Great Expectations, dbt tests, and data contracts. Use when building data quality pipelines, implementing validation rules, or establishing data contracts.

*Source:* `/Users/elliesmith/.cursor/skills/skills/data-quality-frameworks/SKILL.md`

## `data-scientist`

**In chat:** `/data-scientist`

Expert data scientist for advanced analytics, machine learning, and statistical modeling. Handles complex data analysis, predictive modeling, and business intelligence. Use PROACTIVELY for data analysis tasks, ML modeling, statistical analysis, and data-driven insights.

*Source:* `/Users/elliesmith/.cursor/skills/skills/data-scientist/SKILL.md`

## `data-storytelling`

**In chat:** `/data-storytelling`

Transform data into compelling narratives using visualization, context, and persuasive structure. Use when presenting analytics to stakeholders, creating data reports, or building executive presentations.

*Source:* `/Users/elliesmith/.cursor/skills/skills/data-storytelling/SKILL.md`

## `database-admin`

**In chat:** `/database-admin`

Expert database administrator specializing in modern cloud databases, automation, and reliability engineering. Masters AWS/Azure/GCP database services, Infrastructure as Code, high availability, disaster recovery, performance optimization, and compliance. Handles multi-cloud strategies, container databases, and cost optimization. Use PROACTIVELY for database architecture, operations, or reliability engineering.

*Source:* `/Users/elliesmith/.cursor/skills/skills/database-admin/SKILL.md`

## `database-architect`

**In chat:** `/database-architect`

Expert database architect specializing in data layer design from scratch, technology selection, schema modeling, and scalable database architectures. Masters SQL/NoSQL/TimeSeries database selection, normalization strategies, migration planning, and performance-first design. Handles both greenfield architectures and re-architecture of existing systems. Use PROACTIVELY for database architecture, technology selection, or data modeling decisions.

*Source:* `/Users/elliesmith/.cursor/skills/skills/database-architect/SKILL.md`

## `database-cloud-optimization-cost-optimize`

**In chat:** `/database-cloud-optimization-cost-optimize`

"You are a cloud cost optimization expert specializing in reducing infrastructure expenses while maintaining performance and reliability. Analyze cloud spending, identify savings opportunities, and implement cost-effective architectures across AWS, Azure, and GCP."

*Source:* `/Users/elliesmith/.cursor/skills/skills/database-cloud-optimization-cost-optimize/SKILL.md`

## `database-design`

**In chat:** `/database-design`

Database design principles and decision-making. Schema design, indexing strategy, ORM selection, serverless databases.

*Source:* `/Users/elliesmith/.cursor/skills/skills/database-design/SKILL.md`

## `database-migration`

**In chat:** `/database-migration`

Execute database migrations across ORMs and platforms with zero-downtime strategies, data transformation, and rollback procedures. Use when migrating databases, changing schemas, performing data transformations, or implementing zero-downtime deployment strategies.

*Source:* `/Users/elliesmith/.cursor/skills/skills/database-migration/SKILL.md`

## `database-migrations-migration-observability`

**In chat:** `/database-migrations-migration-observability`

Migration monitoring, CDC, and observability infrastructure

*Source:* `/Users/elliesmith/.cursor/skills/skills/database-migrations-migration-observability/SKILL.md`

## `database-migrations-sql-migrations`

**In chat:** `/database-migrations-sql-migrations`

SQL database migrations with zero-downtime strategies for PostgreSQL, MySQL, SQL Server

*Source:* `/Users/elliesmith/.cursor/skills/skills/database-migrations-sql-migrations/SKILL.md`

## `database-optimizer`

**In chat:** `/database-optimizer`

Expert database optimizer specializing in modern performance tuning, query optimization, and scalable architectures. Masters advanced indexing, N+1 resolution, multi-tier caching, partitioning strategies, and cloud database optimization. Handles complex query analysis, migration strategies, and performance monitoring. Use PROACTIVELY for database optimization, performance issues, or scalability challenges.

*Source:* `/Users/elliesmith/.cursor/skills/skills/database-optimizer/SKILL.md`

## `datadog-automation`

**In chat:** `/datadog-automation`

"Automate Datadog tasks via Rube MCP (Composio): query metrics, search logs, manage monitors/dashboards, create events and downtimes. Always search tools first for current schemas."

*Source:* `/Users/elliesmith/.cursor/skills/skills/datadog-automation/SKILL.md`

## `dbt-transformation-patterns`

**In chat:** `/dbt-transformation-patterns`

Master dbt (data build tool) for analytics engineering with model organization, testing, documentation, and incremental strategies. Use when building data transformations, creating data models, or implementing analytics engineering best practices.

*Source:* `/Users/elliesmith/.cursor/skills/skills/dbt-transformation-patterns/SKILL.md`

## `debugger`

**In chat:** `/debugger`

Debugging specialist for errors, test failures, and unexpected behavior. Use proactively when encountering any issues.

*Source:* `/Users/elliesmith/.cursor/skills/skills/debugger/SKILL.md`

## `debugging-strategies`

**In chat:** `/debugging-strategies`

Master systematic debugging techniques, profiling tools, and root cause analysis to efficiently track down bugs across any codebase or technology stack. Use when investigating bugs, performance issues, or unexpected behavior.

*Source:* `/Users/elliesmith/.cursor/skills/skills/debugging-strategies/SKILL.md`

## `debugging-toolkit-smart-debug`

**In chat:** `/debugging-toolkit-smart-debug`

"Use when working with debugging toolkit smart debug"

*Source:* `/Users/elliesmith/.cursor/skills/skills/debugging-toolkit-smart-debug/SKILL.md`

## `deep-research`

**In chat:** `/deep-research`

"Execute autonomous multi-step research using Google Gemini Deep Research Agent. Use for: market analysis, competitive landscaping, literature reviews, technical research, due diligence. Takes 2-10 minutes but produces detailed, cited reports. Costs $2-5 per task."

*Source:* `/Users/elliesmith/.cursor/skills/skills/deep-research/SKILL.md`

## `defi-protocol-templates`

**In chat:** `/defi-protocol-templates`

Implement DeFi protocols with production-ready templates for staking, AMMs, governance, and lending systems. Use when building decentralized finance applications or smart contract protocols.

*Source:* `/Users/elliesmith/.cursor/skills/skills/defi-protocol-templates/SKILL.md`

## `dependency-management-deps-audit`

**In chat:** `/dependency-management-deps-audit`

"You are a dependency security expert specializing in vulnerability scanning, license compliance, and supply chain security. Analyze project dependencies for known vulnerabilities, licensing issues, outdated packages, and provide actionable remediation strategies."

*Source:* `/Users/elliesmith/.cursor/skills/skills/dependency-management-deps-audit/SKILL.md`

## `dependency-upgrade`

**In chat:** `/dependency-upgrade`

Manage major dependency version upgrades with compatibility analysis, staged rollout, and comprehensive testing. Use when upgrading framework versions, updating major dependencies, or managing breaking changes in libraries.

*Source:* `/Users/elliesmith/.cursor/skills/skills/dependency-upgrade/SKILL.md`

## `deployment-engineer`

**In chat:** `/deployment-engineer`

Expert deployment engineer specializing in modern CI/CD pipelines, GitOps workflows, and advanced deployment automation. Masters GitHub Actions, ArgoCD/Flux, progressive delivery, container security, and platform engineering. Handles zero-downtime deployments, security scanning, and developer experience optimization. Use PROACTIVELY for CI/CD design, GitOps implementation, or deployment automation.

*Source:* `/Users/elliesmith/.cursor/skills/skills/deployment-engineer/SKILL.md`

## `deployment-pipeline-design`

**In chat:** `/deployment-pipeline-design`

Design multi-stage CI/CD pipelines with approval gates, security checks, and deployment orchestration. Use when architecting deployment workflows, setting up continuous delivery, or implementing GitOps practices.

*Source:* `/Users/elliesmith/.cursor/skills/skills/deployment-pipeline-design/SKILL.md`

## `deployment-procedures`

**In chat:** `/deployment-procedures`

Production deployment principles and decision-making. Safe deployment workflows, rollback strategies, and verification. Teaches thinking, not scripts.

*Source:* `/Users/elliesmith/.cursor/skills/skills/deployment-procedures/SKILL.md`

## `deployment-validation-config-validate`

**In chat:** `/deployment-validation-config-validate`

"You are a configuration management expert specializing in validating, testing, and ensuring the correctness of application configurations. Create comprehensive validation schemas, implement configurat"

*Source:* `/Users/elliesmith/.cursor/skills/skills/deployment-validation-config-validate/SKILL.md`

## `design-md`

**In chat:** `/design-md`

"Analyze Stitch projects and synthesize a semantic design system into DESIGN.md files"

*Source:* `/Users/elliesmith/.cursor/skills/skills/design-md/SKILL.md`

## `design-orchestration`

**In chat:** `/design-orchestration`

Orchestrates design workflows by routing work through brainstorming, multi-agent review, and execution readiness in the correct order. Prevents premature implementation, skipped validation, and unreviewed high-risk designs.

*Source:* `/Users/elliesmith/.cursor/skills/skills/design-orchestration/SKILL.md`

## `devops-troubleshooter`

**In chat:** `/devops-troubleshooter`

Expert DevOps troubleshooter specializing in rapid incident response, advanced debugging, and modern observability. Masters log analysis, distributed tracing, Kubernetes debugging, performance optimization, and root cause analysis. Handles production outages, system reliability, and preventive monitoring. Use PROACTIVELY for debugging, incident response, or system troubleshooting.

*Source:* `/Users/elliesmith/.cursor/skills/skills/devops-troubleshooter/SKILL.md`

## `discord-automation`

**In chat:** `/discord-automation`

"Automate Discord tasks via Rube MCP (Composio): messages, channels, roles, webhooks, reactions. Always search tools first for current schemas."

*Source:* `/Users/elliesmith/.cursor/skills/skills/discord-automation/SKILL.md`

## `discord-bot-architect`

**In chat:** `/discord-bot-architect`

"Specialized skill for building production-ready Discord bots. Covers Discord.js (JavaScript) and Pycord (Python), gateway intents, slash commands, interactive components, rate limiting, and sharding."

*Source:* `/Users/elliesmith/.cursor/skills/skills/discord-bot-architect/SKILL.md`

## `dispatching-parallel-agents`

**In chat:** `/dispatching-parallel-agents`

Use when facing 2+ independent tasks that can be worked on without shared state or sequential dependencies

*Source:* `/Users/elliesmith/.cursor/skills/skills/dispatching-parallel-agents/SKILL.md`

## `distributed-debugging-debug-trace`

**In chat:** `/distributed-debugging-debug-trace`

"You are a debugging expert specializing in setting up comprehensive debugging environments, distributed tracing, and diagnostic tools. Configure debugging workflows, implement tracing solutions, and establish troubleshooting practices for development and production environments."

*Source:* `/Users/elliesmith/.cursor/skills/skills/distributed-debugging-debug-trace/SKILL.md`

## `distributed-tracing`

**In chat:** `/distributed-tracing`

Implement distributed tracing with Jaeger and Tempo to track requests across microservices and identify performance bottlenecks. Use when debugging microservices, analyzing request flows, or implementing observability for distributed systems.

*Source:* `/Users/elliesmith/.cursor/skills/skills/distributed-tracing/SKILL.md`

## `django-pro`

**In chat:** `/django-pro`

Master Django 5.x with async views, DRF, Celery, and Django Channels. Build scalable web applications with proper architecture, testing, and deployment. Use PROACTIVELY for Django development, ORM optimization, or complex Django patterns.

*Source:* `/Users/elliesmith/.cursor/skills/skills/django-pro/SKILL.md`

## `doc-coauthoring`

**In chat:** `/doc-coauthoring`

Guide users through a structured workflow for co-authoring documentation. Use when user wants to write documentation, proposals, technical specs, decision docs, or similar structured content. This workflow helps users efficiently transfer context, refine content through iteration, and verify the doc works for readers. Trigger when user mentions writing docs, creating proposals, drafting specs, or similar documentation tasks.

*Source:* `/Users/elliesmith/.cursor/skills/skills/doc-coauthoring/SKILL.md`

## `docker-expert`

**In chat:** `/docker-expert`

Docker containerization expert with deep knowledge of multi-stage builds, image optimization, container security, Docker Compose orchestration, and production deployment patterns. Use PROACTIVELY for Dockerfile optimization, container issues, image size problems, security hardening, networking, and orchestration challenges.

*Source:* `/Users/elliesmith/.cursor/skills/skills/docker-expert/SKILL.md`

## `docs-architect`

**In chat:** `/docs-architect`

Creates comprehensive technical documentation from existing codebases. Analyzes architecture, design patterns, and implementation details to produce long-form technical manuals and ebooks. Use PROACTIVELY for system documentation, architecture guides, or technical deep-dives.

*Source:* `/Users/elliesmith/.cursor/skills/skills/docs-architect/SKILL.md`

## `documentation-generation-doc-generate`

**In chat:** `/documentation-generation-doc-generate`

"You are a documentation expert specializing in creating comprehensive, maintainable documentation from code. Generate API docs, architecture diagrams, user guides, and technical references using AI-powered analysis and industry best practices."

*Source:* `/Users/elliesmith/.cursor/skills/skills/documentation-generation-doc-generate/SKILL.md`

## `documentation-templates`

**In chat:** `/documentation-templates`

Documentation templates and structure guidelines. README, API docs, code comments, and AI-friendly documentation.

*Source:* `/Users/elliesmith/.cursor/skills/skills/documentation-templates/SKILL.md`

## `docusign-automation`

**In chat:** `/docusign-automation`

"Automate DocuSign tasks via Rube MCP (Composio): templates, envelopes, signatures, document management. Always search tools first for current schemas."

*Source:* `/Users/elliesmith/.cursor/skills/skills/docusign-automation/SKILL.md`

## `docx`

**In chat:** `/docx-official`

"Comprehensive document creation, editing, and analysis with support for tracked changes, comments, formatting preservation, and text extraction. When Claude needs to work with professional documents (.docx files) for: (1) Creating new documents, (2) Modifying or editing content, (3) Working with tracked changes, (4) Adding comments, or any other document tasks"

*Source:* `/Users/elliesmith/.cursor/skills/skills/docx-official/SKILL.md`

## `dotnet-architect`

**In chat:** `/dotnet-architect`

Expert .NET backend architect specializing in C#, ASP.NET Core, Entity Framework, Dapper, and enterprise application patterns. Masters async/await, dependency injection, caching strategies, and performance optimization. Use PROACTIVELY for .NET API development, code review, or architecture decisions.

*Source:* `/Users/elliesmith/.cursor/skills/skills/dotnet-architect/SKILL.md`

## `dotnet-backend`

**In chat:** `/dotnet-backend`

Build ASP.NET Core 8+ backend services with EF Core, auth, background jobs, and production API patterns.

*Source:* `/Users/elliesmith/.cursor/skills/skills/dotnet-backend/SKILL.md`

## `dotnet-backend-patterns`

**In chat:** `/dotnet-backend-patterns`

Master C#/.NET backend development patterns for building robust APIs, MCP servers, and enterprise applications. Covers async/await, dependency injection, Entity Framework Core, Dapper, configuration, caching, and testing with xUnit. Use when developing .NET backends, reviewing C# code, or designing API architectures.

*Source:* `/Users/elliesmith/.cursor/skills/skills/dotnet-backend-patterns/SKILL.md`

## `dropbox-automation`

**In chat:** `/dropbox-automation`

"Automate Dropbox file management, sharing, search, uploads, downloads, and folder operations via Rube MCP (Composio). Always search tools first for current schemas."

*Source:* `/Users/elliesmith/.cursor/skills/skills/dropbox-automation/SKILL.md`

## `dx-optimizer`

**In chat:** `/dx-optimizer`

Developer Experience specialist. Improves tooling, setup, and workflows. Use PROACTIVELY when setting up new projects, after team feedback, or when development friction is noticed.

*Source:* `/Users/elliesmith/.cursor/skills/skills/dx-optimizer/SKILL.md`

## `e2e-testing-patterns`

**In chat:** `/e2e-testing-patterns`

Master end-to-end testing with Playwright and Cypress to build reliable test suites that catch bugs, improve confidence, and enable fast deployment. Use when implementing E2E tests, debugging flaky tests, or establishing testing standards.

*Source:* `/Users/elliesmith/.cursor/skills/skills/e2e-testing-patterns/SKILL.md`

## `elixir-pro`

**In chat:** `/elixir-pro`

Write idiomatic Elixir code with OTP patterns, supervision trees, and Phoenix LiveView. Masters concurrency, fault tolerance, and distributed systems. Use PROACTIVELY for Elixir refactoring, OTP design, or complex BEAM optimizations.

*Source:* `/Users/elliesmith/.cursor/skills/skills/elixir-pro/SKILL.md`

## `email-sequence`

**In chat:** `/email-sequence`

When the user wants to create or optimize an email sequence, drip campaign, automated email flow, or lifecycle email program. Also use when the user mentions "email sequence," "drip campaign," "nurture sequence," "onboarding emails," "welcome sequence," "re-engagement emails," "email automation," or "lifecycle emails." For in-app onboarding, see onboarding-cro.

*Source:* `/Users/elliesmith/.cursor/skills/skills/email-sequence/SKILL.md`

## `email-systems`

**In chat:** `/email-systems`

"Email has the highest ROI of any marketing channel. $36 for every $1 spent. Yet most startups treat it as an afterthought - bulk blasts, no personalization, landing in spam folders. This skill covers transactional email that works, marketing automation that converts, deliverability that reaches inboxes, and the infrastructure decisions that scale. Use when: keywords, file_patterns, code_patterns."

*Source:* `/Users/elliesmith/.cursor/skills/skills/email-systems/SKILL.md`

## `embedding-strategies`

**In chat:** `/embedding-strategies`

Select and optimize embedding models for semantic search and RAG applications. Use when choosing embedding models, implementing chunking strategies, or optimizing embedding quality for specific domains.

*Source:* `/Users/elliesmith/.cursor/skills/skills/embedding-strategies/SKILL.md`

## `employment-contract-templates`

**In chat:** `/employment-contract-templates`

Create employment contracts, offer letters, and HR policy documents following legal best practices. Use when drafting employment agreements, creating HR policies, or standardizing employment documentation.

*Source:* `/Users/elliesmith/.cursor/skills/skills/employment-contract-templates/SKILL.md`

## `environment-setup-guide`

**In chat:** `/environment-setup-guide`

"Guide developers through setting up development environments with proper tools, dependencies, and configurations"

*Source:* `/Users/elliesmith/.cursor/skills/skills/environment-setup-guide/SKILL.md`

## `error-debugging-error-analysis`

**In chat:** `/error-debugging-error-analysis`

"You are an expert error analysis specialist with deep expertise in debugging distributed systems, analyzing production incidents, and implementing comprehensive observability solutions."

*Source:* `/Users/elliesmith/.cursor/skills/skills/error-debugging-error-analysis/SKILL.md`

## `error-debugging-error-trace`

**In chat:** `/error-debugging-error-trace`

"You are an error tracking and observability expert specializing in implementing comprehensive error monitoring solutions. Set up error tracking systems, configure alerts, implement structured logging, and ensure teams can quickly identify and resolve production issues."

*Source:* `/Users/elliesmith/.cursor/skills/skills/error-debugging-error-trace/SKILL.md`

## `error-debugging-multi-agent-review`

**In chat:** `/error-debugging-multi-agent-review`

"Use when working with error debugging multi agent review"

*Source:* `/Users/elliesmith/.cursor/skills/skills/error-debugging-multi-agent-review/SKILL.md`

## `error-detective`

**In chat:** `/error-detective`

Search logs and codebases for error patterns, stack traces, and anomalies. Correlates errors across systems and identifies root causes. Use PROACTIVELY when debugging issues, analyzing logs, or investigating production errors.

*Source:* `/Users/elliesmith/.cursor/skills/skills/error-detective/SKILL.md`

## `error-diagnostics-error-analysis`

**In chat:** `/error-diagnostics-error-analysis`

"You are an expert error analysis specialist with deep expertise in debugging distributed systems, analyzing production incidents, and implementing comprehensive observability solutions."

*Source:* `/Users/elliesmith/.cursor/skills/skills/error-diagnostics-error-analysis/SKILL.md`

## `error-diagnostics-error-trace`

**In chat:** `/error-diagnostics-error-trace`

"You are an error tracking and observability expert specializing in implementing comprehensive error monitoring solutions. Set up error tracking systems, configure alerts, implement structured logging,"

*Source:* `/Users/elliesmith/.cursor/skills/skills/error-diagnostics-error-trace/SKILL.md`

## `error-diagnostics-smart-debug`

**In chat:** `/error-diagnostics-smart-debug`

"Use when working with error diagnostics smart debug"

*Source:* `/Users/elliesmith/.cursor/skills/skills/error-diagnostics-smart-debug/SKILL.md`

## `error-handling-patterns`

**In chat:** `/error-handling-patterns`

Master error handling patterns across languages including exceptions, Result types, error propagation, and graceful degradation to build resilient applications. Use when implementing error handling, designing APIs, or improving application reliability.

*Source:* `/Users/elliesmith/.cursor/skills/skills/error-handling-patterns/SKILL.md`

## `Ethical Hacking Methodology`

**In chat:** `/ethical-hacking-methodology`

This skill should be used when the user asks to "learn ethical hacking", "understand penetration testing lifecycle", "perform reconnaissance", "conduct security scanning", "exploit vulnerabilities", or "write penetration test reports". It provides comprehensive ethical hacking methodology and techniques.

*Source:* `/Users/elliesmith/.cursor/skills/skills/ethical-hacking-methodology/SKILL.md`

## `evaluation`

**In chat:** `/evaluation`

"Build evaluation frameworks for agent systems"

*Source:* `/Users/elliesmith/.cursor/skills/skills/evaluation/SKILL.md`

## `event-sourcing-architect`

**In chat:** `/event-sourcing-architect`

"Expert in event sourcing, CQRS, and event-driven architecture patterns. Masters event store design, projection building, saga orchestration, and eventual consistency patterns. Use PROACTIVELY for event-sourced systems, audit trails, or temporal queries."

*Source:* `/Users/elliesmith/.cursor/skills/skills/event-sourcing-architect/SKILL.md`

## `event-store-design`

**In chat:** `/event-store-design`

Design and implement event stores for event-sourced systems. Use when building event sourcing infrastructure, choosing event store technologies, or implementing event persistence patterns.

*Source:* `/Users/elliesmith/.cursor/skills/skills/event-store-design/SKILL.md`

## `exa-search`

**In chat:** `/exa-search`

Semantic search, similar content discovery, and structured research using Exa API

*Source:* `/Users/elliesmith/.cursor/skills/skills/exa-search/SKILL.md`

## `executing-plans`

**In chat:** `/executing-plans`

Use when you have a written implementation plan to execute in a separate session with review checkpoints

*Source:* `/Users/elliesmith/.cursor/skills/skills/executing-plans/SKILL.md`

## `expo-deployment`

**In chat:** `/expo-deployment`

"Deploy Expo apps to production"

*Source:* `/Users/elliesmith/.cursor/skills/skills/expo-deployment/SKILL.md`

## `fal-audio`

**In chat:** `/fal-audio`

"Text-to-speech and speech-to-text using fal.ai audio models"

*Source:* `/Users/elliesmith/.cursor/skills/skills/fal-audio/SKILL.md`

## `fal-generate`

**In chat:** `/fal-generate`

"Generate images and videos using fal.ai AI models"

*Source:* `/Users/elliesmith/.cursor/skills/skills/fal-generate/SKILL.md`

## `fal-image-edit`

**In chat:** `/fal-image-edit`

"AI-powered image editing with style transfer and object removal"

*Source:* `/Users/elliesmith/.cursor/skills/skills/fal-image-edit/SKILL.md`

## `fal-platform`

**In chat:** `/fal-platform`

"Platform APIs for model management, pricing, and usage tracking"

*Source:* `/Users/elliesmith/.cursor/skills/skills/fal-platform/SKILL.md`

## `fal-upscale`

**In chat:** `/fal-upscale`

"Upscale and enhance image and video resolution using AI"

*Source:* `/Users/elliesmith/.cursor/skills/skills/fal-upscale/SKILL.md`

## `fal-workflow`

**In chat:** `/fal-workflow`

"Generate workflow JSON files for chaining AI models"

*Source:* `/Users/elliesmith/.cursor/skills/skills/fal-workflow/SKILL.md`

## `fastapi-pro`

**In chat:** `/fastapi-pro`

Build high-performance async APIs with FastAPI, SQLAlchemy 2.0, and Pydantic V2. Master microservices, WebSockets, and modern Python async patterns. Use PROACTIVELY for FastAPI development, async optimization, or API architecture.

*Source:* `/Users/elliesmith/.cursor/skills/skills/fastapi-pro/SKILL.md`

## `fastapi-router-py`

**In chat:** `/fastapi-router-py`

Create FastAPI routers with CRUD operations, authentication dependencies, and proper response models. Use when building REST API endpoints, creating new routes, implementing CRUD operations, or adding authenticated endpoints in FastAPI applications.

*Source:* `/Users/elliesmith/.cursor/skills/skills/fastapi-router-py/SKILL.md`

## `fastapi-templates`

**In chat:** `/fastapi-templates`

Create production-ready FastAPI projects with async patterns, dependency injection, and comprehensive error handling. Use when building new FastAPI applications or setting up backend API projects.

*Source:* `/Users/elliesmith/.cursor/skills/skills/fastapi-templates/SKILL.md`

## `ffuf-claude-skill`

**In chat:** `/ffuf-claude-skill`

"Web fuzzing with ffuf"

*Source:* `/Users/elliesmith/.cursor/skills/skills/ffuf-claude-skill/SKILL.md`

## `figma-automation`

**In chat:** `/figma-automation`

"Automate Figma tasks via Rube MCP (Composio): files, components, design tokens, comments, exports. Always search tools first for current schemas."

*Source:* `/Users/elliesmith/.cursor/skills/skills/figma-automation/SKILL.md`

## `File Path Traversal Testing`

**In chat:** `/file-path-traversal`

This skill should be used when the user asks to "test for directory traversal", "exploit path traversal vulnerabilities", "read arbitrary files through web applications", "find LFI vulnerabilities", or "access files outside web root". It provides comprehensive file path traversal attack and testing methodologies.

*Source:* `/Users/elliesmith/.cursor/skills/skills/file-path-traversal/SKILL.md`

## `file-organizer`

**In chat:** `/file-organizer`

Intelligently organizes files and folders by understanding context, finding duplicates, and suggesting better organizational structures. Use when user wants to clean up directories, organize downloads, remove duplicates, or restructure projects.

*Source:* `/Users/elliesmith/.cursor/skills/skills/file-organizer/SKILL.md`

## `file-uploads`

**In chat:** `/file-uploads`

"Expert at handling file uploads and cloud storage. Covers S3, Cloudflare R2, presigned URLs, multipart uploads, and image optimization. Knows how to handle large files without blocking. Use when: file upload, S3, R2, presigned URL, multipart."

*Source:* `/Users/elliesmith/.cursor/skills/skills/file-uploads/SKILL.md`

## `find-bugs`

**In chat:** `/find-bugs`

"Find bugs, security vulnerabilities, and code quality issues in local branch changes. Use when asked to review changes, find bugs, security review, or audit code on the current branch."

*Source:* `/Users/elliesmith/.cursor/skills/skills/find-bugs/SKILL.md`

## `finishing-a-development-branch`

**In chat:** `/finishing-a-development-branch`

Use when implementation is complete, all tests pass, and you need to decide how to integrate the work - guides completion of development work by presenting structured options for merge, PR, or cleanup

*Source:* `/Users/elliesmith/.cursor/skills/skills/finishing-a-development-branch/SKILL.md`

## `firebase`

**In chat:** `/firebase`

"Firebase gives you a complete backend in minutes - auth, database, storage, functions, hosting. But the ease of setup hides real complexity. Security rules are your last line of defense, and they're often wrong. Firestore queries are limited, and you learn this after you've designed your data model. This skill covers Firebase Authentication, Firestore, Realtime Database, Cloud Functions, Cloud Storage, and Firebase Hosting. Key insight: Firebase is optimized for read-heavy, denormalized data. I"

*Source:* `/Users/elliesmith/.cursor/skills/skills/firebase/SKILL.md`

## `firecrawl-scraper`

**In chat:** `/firecrawl-scraper`

Deep web scraping, screenshots, PDF parsing, and website crawling using Firecrawl API

*Source:* `/Users/elliesmith/.cursor/skills/skills/firecrawl-scraper/SKILL.md`

## `firmware-analyst`

**In chat:** `/firmware-analyst`

Expert firmware analyst specializing in embedded systems, IoT security, and hardware reverse engineering. Masters firmware extraction, analysis, and vulnerability research for routers, IoT devices, automotive systems, and industrial controllers. Use PROACTIVELY for firmware security audits, IoT penetration testing, or embedded systems research.

*Source:* `/Users/elliesmith/.cursor/skills/skills/firmware-analyst/SKILL.md`

## `fix-review`

**In chat:** `/fix-review`

"Verify fix commits address audit findings without new bugs"

*Source:* `/Users/elliesmith/.cursor/skills/skills/fix-review/SKILL.md`

## `flutter-expert`

**In chat:** `/flutter-expert`

Master Flutter development with Dart 3, advanced widgets, and multi-platform deployment. Handles state management, animations, testing, and performance optimization for mobile, web, desktop, and embedded platforms. Use PROACTIVELY for Flutter architecture, UI implementation, or cross-platform features.

*Source:* `/Users/elliesmith/.cursor/skills/skills/flutter-expert/SKILL.md`

## `form-cro`

**In chat:** `/form-cro`

Optimize any form that is NOT signup or account registration — including lead capture, contact, demo request, application, survey, quote, and checkout forms. Use when the goal is to increase form completion rate, reduce friction, or improve lead quality without breaking compliance or downstream workflows.

*Source:* `/Users/elliesmith/.cursor/skills/skills/form-cro/SKILL.md`

## `fp-ts-errors`

**In chat:** `/fp-ts-errors`

Handle errors as values using fp-ts Either and TaskEither for cleaner, more predictable TypeScript code. Use when implementing error handling patterns with fp-ts.

*Source:* `/Users/elliesmith/.cursor/skills/skills/fp-ts-errors/SKILL.md`

## `fp-ts-pragmatic`

**In chat:** `/fp-ts-pragmatic`

A practical, jargon-free guide to fp-ts functional programming - the 80/20 approach that gets results without the academic overhead. Use when writing TypeScript with fp-ts library.

*Source:* `/Users/elliesmith/.cursor/skills/skills/fp-ts-pragmatic/SKILL.md`

## `fp-ts-react`

**In chat:** `/fp-ts-react`

Practical patterns for using fp-ts with React - hooks, state, forms, data fetching. Use when building React apps with functional programming patterns. Works with React 18/19, Next.js 14/15.

*Source:* `/Users/elliesmith/.cursor/skills/skills/fp-ts-react/SKILL.md`

## `framework-migration-code-migrate`

**In chat:** `/framework-migration-code-migrate`

"You are a code migration expert specializing in transitioning codebases between frameworks, languages, versions, and platforms. Generate comprehensive migration plans, automated migration scripts, and"

*Source:* `/Users/elliesmith/.cursor/skills/skills/framework-migration-code-migrate/SKILL.md`

## `framework-migration-deps-upgrade`

**In chat:** `/framework-migration-deps-upgrade`

"You are a dependency management expert specializing in safe, incremental upgrades of project dependencies. Plan and execute dependency updates with minimal risk, proper testing, and clear migration pa"

*Source:* `/Users/elliesmith/.cursor/skills/skills/framework-migration-deps-upgrade/SKILL.md`

## `framework-migration-legacy-modernize`

**In chat:** `/framework-migration-legacy-modernize`

"Orchestrate a comprehensive legacy system modernization using the strangler fig pattern, enabling gradual replacement of outdated components while maintaining continuous business operations through ex"

*Source:* `/Users/elliesmith/.cursor/skills/skills/framework-migration-legacy-modernize/SKILL.md`

## `free-tool-strategy`

**In chat:** `/free-tool-strategy`

When the user wants to plan, evaluate, or build a free tool for marketing purposes — lead generation, SEO value, or brand awareness. Also use when the user mentions "engineering as marketing," "free tool," "marketing tool," "calculator," "generator," "interactive tool," "lead gen tool," "build a tool for leads," or "free resource." This skill bridges engineering and marketing — useful for founders and technical marketers.

*Source:* `/Users/elliesmith/.cursor/skills/skills/free-tool-strategy/SKILL.md`

## `freshdesk-automation`

**In chat:** `/freshdesk-automation`

"Automate Freshdesk helpdesk operations including tickets, contacts, companies, notes, and replies via Rube MCP (Composio). Always search tools first for current schemas."

*Source:* `/Users/elliesmith/.cursor/skills/skills/freshdesk-automation/SKILL.md`

## `freshservice-automation`

**In chat:** `/freshservice-automation`

"Automate Freshservice ITSM tasks via Rube MCP (Composio): create/update tickets, bulk operations, service requests, and outbound emails. Always search tools first for current schemas."

*Source:* `/Users/elliesmith/.cursor/skills/skills/freshservice-automation/SKILL.md`

## `frontend-design`

**In chat:** `/frontend-design`

Create distinctive, production-grade frontend interfaces with intentional aesthetics, high craft, and non-generic visual identity. Use when building or styling web UIs, components, pages, dashboards, or frontend applications.

*Source:* `/Users/elliesmith/.cursor/skills/skills/frontend-design/SKILL.md`

## `frontend-dev-guidelines`

**In chat:** `/frontend-dev-guidelines`

Opinionated frontend development standards for modern React + TypeScript applications. Covers Suspense-first data fetching, lazy loading, feature-based architecture, MUI v7 styling, TanStack Router, performance optimization, and strict TypeScript practices.

*Source:* `/Users/elliesmith/.cursor/skills/skills/frontend-dev-guidelines/SKILL.md`

## `frontend-developer`

**In chat:** `/frontend-developer`

Build React components, implement responsive layouts, and handle client-side state management. Masters React 19, Next.js 15, and modern frontend architecture. Optimizes performance and ensures accessibility. Use PROACTIVELY when creating UI components or fixing frontend issues.

*Source:* `/Users/elliesmith/.cursor/skills/skills/frontend-developer/SKILL.md`

## `frontend-mobile-development-component-scaffold`

**In chat:** `/frontend-mobile-development-component-scaffold`

"You are a React component architecture expert specializing in scaffolding production-ready, accessible, and performant components. Generate complete component implementations with TypeScript, tests, s"

*Source:* `/Users/elliesmith/.cursor/skills/skills/frontend-mobile-development-component-scaffold/SKILL.md`

## `frontend-mobile-security-xss-scan`

**In chat:** `/frontend-mobile-security-xss-scan`

"You are a frontend security specialist focusing on Cross-Site Scripting (XSS) vulnerability detection and prevention. Analyze React, Vue, Angular, and vanilla JavaScript code to identify injection poi"

*Source:* `/Users/elliesmith/.cursor/skills/skills/frontend-mobile-security-xss-scan/SKILL.md`

## `frontend-patterns`

**In chat:** `/cc-skill-frontend-patterns`

Frontend development patterns for React, Next.js, state management, performance optimization, and UI best practices.

*Source:* `/Users/elliesmith/.cursor/skills/skills/cc-skill-frontend-patterns/SKILL.md`

## `frontend-security-coder`

**In chat:** `/frontend-security-coder`

Expert in secure frontend coding practices specializing in XSS prevention, output sanitization, and client-side security patterns. Use PROACTIVELY for frontend security implementations or client-side security code reviews.

*Source:* `/Users/elliesmith/.cursor/skills/skills/frontend-security-coder/SKILL.md`

## `frontend-slides`

**In chat:** `/frontend-slides`

Create stunning, animation-rich HTML presentations from scratch or by converting PowerPoint files. Use when the user wants to build a presentation, convert a PPT/PPTX to web, or create slides for a talk/pitch. Helps non-designers discover their aesthetic through visual exploration rather than abstract choices.

*Source:* `/Users/elliesmith/.cursor/skills/skills/frontend-slides/SKILL.md`

## `frontend-ui-dark-ts`

**In chat:** `/frontend-ui-dark-ts`

Build dark-themed React applications using Tailwind CSS with custom theming, glassmorphism effects, and Framer Motion animations. Use when creating dashboards, admin panels, or data-rich interfaces with a refined dark aesthetic.

*Source:* `/Users/elliesmith/.cursor/skills/skills/frontend-ui-dark-ts/SKILL.md`

## `full-stack-orchestration-full-stack-feature`

**In chat:** `/full-stack-orchestration-full-stack-feature`

"Use when working with full stack orchestration full stack feature"

*Source:* `/Users/elliesmith/.cursor/skills/skills/full-stack-orchestration-full-stack-feature/SKILL.md`

## `game-art`

**In chat:** `/game-art`

Game art principles. Visual style selection, asset pipeline, animation workflow.

*Source:* `/Users/elliesmith/.cursor/skills/skills/game-development/game-art/SKILL.md`

## `game-audio`

**In chat:** `/game-audio`

Game audio principles. Sound design, music integration, adaptive audio systems.

*Source:* `/Users/elliesmith/.cursor/skills/skills/game-development/game-audio/SKILL.md`

## `game-design`

**In chat:** `/game-design`

Game design principles. GDD structure, balancing, player psychology, progression.

*Source:* `/Users/elliesmith/.cursor/skills/skills/game-development/game-design/SKILL.md`

## `game-development`

**In chat:** `/game-development`

Game development orchestrator. Routes to platform-specific skills based on project needs.

*Source:* `/Users/elliesmith/.cursor/skills/skills/game-development/SKILL.md`

## `gcp-cloud-run`

**In chat:** `/gcp-cloud-run`

"Specialized skill for building production-ready serverless applications on GCP. Covers Cloud Run services (containerized), Cloud Run Functions (event-driven), cold start optimization, and event-driven architecture with Pub/Sub."

*Source:* `/Users/elliesmith/.cursor/skills/skills/gcp-cloud-run/SKILL.md`

## `gdpr-data-handling`

**In chat:** `/gdpr-data-handling`

Implement GDPR-compliant data handling with consent management, data subject rights, and privacy by design. Use when building systems that process EU personal data, implementing privacy controls, or conducting GDPR compliance reviews.

*Source:* `/Users/elliesmith/.cursor/skills/skills/gdpr-data-handling/SKILL.md`

## `gemini-api-dev`

**In chat:** `/gemini-api-dev`

Use this skill when building applications with Gemini models, Gemini API, working with multimodal content (text, images, audio, video), implementing function calling, using structured outputs, or needing current model specifications. Covers SDK usage (google-genai for Python, @google/genai for JavaScript/TypeScript), model selection, and API capabilities.

*Source:* `/Users/elliesmith/.cursor/skills/skills/gemini-api-dev/SKILL.md`

## `geo-fundamentals`

**In chat:** `/geo-fundamentals`

Generative Engine Optimization for AI search engines (ChatGPT, Claude, Perplexity).

*Source:* `/Users/elliesmith/.cursor/skills/skills/geo-fundamentals/SKILL.md`

## `git-advanced-workflows`

**In chat:** `/git-advanced-workflows`

Master advanced Git workflows including rebasing, cherry-picking, bisect, worktrees, and reflog to maintain clean history and recover from any situation. Use when managing complex Git histories, collaborating on feature branches, or troubleshooting repository issues.

*Source:* `/Users/elliesmith/.cursor/skills/skills/git-advanced-workflows/SKILL.md`

## `git-pr-workflows-git-workflow`

**In chat:** `/git-pr-workflows-git-workflow`

"Orchestrate a comprehensive git workflow from code review through PR creation, leveraging specialized agents for quality assurance, testing, and deployment readiness. This workflow implements modern g"

*Source:* `/Users/elliesmith/.cursor/skills/skills/git-pr-workflows-git-workflow/SKILL.md`

## `git-pr-workflows-onboard`

**In chat:** `/git-pr-workflows-onboard`

"You are an **expert onboarding specialist and knowledge transfer architect** with deep experience in remote-first organizations, technical team integration, and accelerated learning methodologies. You"

*Source:* `/Users/elliesmith/.cursor/skills/skills/git-pr-workflows-onboard/SKILL.md`

## `git-pr-workflows-pr-enhance`

**In chat:** `/git-pr-workflows-pr-enhance`

"You are a PR optimization expert specializing in creating high-quality pull requests that facilitate efficient code reviews. Generate comprehensive PR descriptions, automate review processes, and ensu"

*Source:* `/Users/elliesmith/.cursor/skills/skills/git-pr-workflows-pr-enhance/SKILL.md`

## `git-pushing`

**In chat:** `/git-pushing`

Stage, commit, and push git changes with conventional commit messages. Use when user wants to commit and push changes, mentions pushing to remote, or asks to save and push their work. Also activates when user says "push changes", "commit and push", "push this", "push to github", or similar git workflow requests.

*Source:* `/Users/elliesmith/.cursor/skills/skills/git-pushing/SKILL.md`

## `github-actions-templates`

**In chat:** `/github-actions-templates`

Create production-ready GitHub Actions workflows for automated testing, building, and deploying applications. Use when setting up CI/CD with GitHub Actions, automating development workflows, or creating reusable workflow templates.

*Source:* `/Users/elliesmith/.cursor/skills/skills/github-actions-templates/SKILL.md`

## `github-automation`

**In chat:** `/github-automation`

"Automate GitHub repositories, issues, pull requests, branches, CI/CD, and permissions via Rube MCP (Composio). Manage code workflows, review PRs, search code, and handle deployments programmatically."

*Source:* `/Users/elliesmith/.cursor/skills/skills/github-automation/SKILL.md`

## `github-issue-creator`

**In chat:** `/github-issue-creator`

Convert raw notes, error logs, voice dictation, or screenshots into crisp GitHub-flavored markdown issue reports. Use when the user pastes bug info, error messages, or informal descriptions and wants a structured GitHub issue. Supports images/GIFs for visual evidence.

*Source:* `/Users/elliesmith/.cursor/skills/skills/github-issue-creator/SKILL.md`

## `github-workflow-automation`

**In chat:** `/github-workflow-automation`

"Automate GitHub workflows with AI assistance. Includes PR reviews, issue triage, CI/CD integration, and Git operations. Use when automating GitHub workflows, setting up PR review automation, creating GitHub Actions, or triaging issues."

*Source:* `/Users/elliesmith/.cursor/skills/skills/github-workflow-automation/SKILL.md`

## `gitlab-automation`

**In chat:** `/gitlab-automation`

"Automate GitLab project management, issues, merge requests, pipelines, branches, and user operations via Rube MCP (Composio). Always search tools first for current schemas."

*Source:* `/Users/elliesmith/.cursor/skills/skills/gitlab-automation/SKILL.md`

## `gitlab-ci-patterns`

**In chat:** `/gitlab-ci-patterns`

Build GitLab CI/CD pipelines with multi-stage workflows, caching, and distributed runners for scalable automation. Use when implementing GitLab CI/CD, optimizing pipeline performance, or setting up automated testing and deployment.

*Source:* `/Users/elliesmith/.cursor/skills/skills/gitlab-ci-patterns/SKILL.md`

## `gitops-workflow`

**In chat:** `/gitops-workflow`

Implement GitOps workflows with ArgoCD and Flux for automated, declarative Kubernetes deployments with continuous reconciliation. Use when implementing GitOps practices, automating Kubernetes deployments, or setting up declarative infrastructure management.

*Source:* `/Users/elliesmith/.cursor/skills/skills/gitops-workflow/SKILL.md`

## `gmail-automation`

**In chat:** `/gmail-automation`

"Automate Gmail tasks via Rube MCP (Composio): send/reply, search, labels, drafts, attachments. Always search tools first for current schemas."

*Source:* `/Users/elliesmith/.cursor/skills/skills/gmail-automation/SKILL.md`

## `go-concurrency-patterns`

**In chat:** `/go-concurrency-patterns`

Master Go concurrency with goroutines, channels, sync primitives, and context. Use when building concurrent Go applications, implementing worker pools, or debugging race conditions.

*Source:* `/Users/elliesmith/.cursor/skills/skills/go-concurrency-patterns/SKILL.md`

## `go-playwright`

**In chat:** `/go-playwright`

Expert capability for robust, stealthy, and efficient browser automation using Playwright Go.

*Source:* `/Users/elliesmith/.cursor/skills/skills/go-playwright/SKILL.md`

## `go-rod-master`

**In chat:** `/go-rod-master`

"Comprehensive guide for browser automation and web scraping with go-rod (Chrome DevTools Protocol) including stealth anti-bot-detection patterns."

*Source:* `/Users/elliesmith/.cursor/skills/skills/go-rod-master/SKILL.md`

## `godot-gdscript-patterns`

**In chat:** `/godot-gdscript-patterns`

Master Godot 4 GDScript patterns including signals, scenes, state machines, and optimization. Use when building Godot games, implementing game systems, or learning GDScript best practices.

*Source:* `/Users/elliesmith/.cursor/skills/skills/godot-gdscript-patterns/SKILL.md`

## `golang-pro`

**In chat:** `/golang-pro`

Master Go 1.21+ with modern patterns, advanced concurrency, performance optimization, and production-ready microservices. Expert in the latest Go ecosystem including generics, workspaces, and cutting-edge frameworks. Use PROACTIVELY for Go development, architecture design, or performance optimization.

*Source:* `/Users/elliesmith/.cursor/skills/skills/golang-pro/SKILL.md`

## `google-analytics-automation`

**In chat:** `/google-analytics-automation`

"Automate Google Analytics tasks via Rube MCP (Composio): run reports, list accounts/properties, funnels, pivots, key events. Always search tools first for current schemas."

*Source:* `/Users/elliesmith/.cursor/skills/skills/google-analytics-automation/SKILL.md`

## `google-calendar-automation`

**In chat:** `/google-calendar-automation`

"Automate Google Calendar events, scheduling, availability checks, and attendee management via Rube MCP (Composio). Create events, find free slots, manage attendees, and list calendars programmatically."

*Source:* `/Users/elliesmith/.cursor/skills/skills/google-calendar-automation/SKILL.md`

## `google-drive-automation`

**In chat:** `/google-drive-automation`

"Automate Google Drive file operations (upload, download, search, share, organize) via Rube MCP (Composio). Upload/download files, manage folders, share with permissions, and search across drives programmatically."

*Source:* `/Users/elliesmith/.cursor/skills/skills/google-drive-automation/SKILL.md`

## `googlesheets-automation`

**In chat:** `/googlesheets-automation`

"Automate Google Sheets operations (read, write, format, filter, manage spreadsheets) via Rube MCP (Composio). Read/write data, manage tabs, apply formatting, and search rows programmatically."

*Source:* `/Users/elliesmith/.cursor/skills/skills/googlesheets-automation/SKILL.md`

## `grafana-dashboards`

**In chat:** `/grafana-dashboards`

Create and manage production Grafana dashboards for real-time visualization of system and application metrics. Use when building monitoring dashboards, visualizing metrics, or creating operational observability interfaces.

*Source:* `/Users/elliesmith/.cursor/skills/skills/grafana-dashboards/SKILL.md`

## `graphql`

**In chat:** `/graphql`

"GraphQL gives clients exactly the data they need - no more, no less. One endpoint, typed schema, introspection. But the flexibility that makes it powerful also makes it dangerous. Without proper controls, clients can craft queries that bring down your server. This skill covers schema design, resolvers, DataLoader for N+1 prevention, federation for microservices, and client integration with Apollo/urql. Key insight: GraphQL is a contract. The schema is the API documentation. Design it carefully."

*Source:* `/Users/elliesmith/.cursor/skills/skills/graphql/SKILL.md`

## `graphql-architect`

**In chat:** `/graphql-architect`

Master modern GraphQL with federation, performance optimization, and enterprise security. Build scalable schemas, implement advanced caching, and design real-time systems. Use PROACTIVELY for GraphQL architecture or performance optimization.

*Source:* `/Users/elliesmith/.cursor/skills/skills/graphql-architect/SKILL.md`

## `haskell-pro`

**In chat:** `/haskell-pro`

Expert Haskell engineer specializing in advanced type systems, pure functional design, and high-reliability software. Use PROACTIVELY for type-level programming, concurrency, and architecture guidance.

*Source:* `/Users/elliesmith/.cursor/skills/skills/haskell-pro/SKILL.md`

## `helm-chart-scaffolding`

**In chat:** `/helm-chart-scaffolding`

Design, organize, and manage Helm charts for templating and packaging Kubernetes applications with reusable configurations. Use when creating Helm charts, packaging Kubernetes applications, or implementing templated deployments.

*Source:* `/Users/elliesmith/.cursor/skills/skills/helm-chart-scaffolding/SKILL.md`

## `helpdesk-automation`

**In chat:** `/helpdesk-automation`

"Automate HelpDesk tasks via Rube MCP (Composio): list tickets, manage views, use canned responses, and configure custom fields. Always search tools first for current schemas."

*Source:* `/Users/elliesmith/.cursor/skills/skills/helpdesk-automation/SKILL.md`

## `hosted-agents-v2-py`

**In chat:** `/hosted-agents-v2-py`

Build hosted agents using Azure AI Projects SDK with ImageBasedHostedAgentDefinition. Use when creating container-based agents that run custom code in Azure AI Foundry. Triggers: "ImageBasedHostedAgentDefinition", "hosted agent", "container agent", "create_version", "ProtocolVersionRecord", "AgentProtocol.RESPONSES".

*Source:* `/Users/elliesmith/.cursor/skills/skills/hosted-agents-v2-py/SKILL.md`

## `hr-pro`

**In chat:** `/hr-pro`

Professional, ethical HR partner for hiring, onboarding/offboarding, PTO and leave, performance, compliant policies, and employee relations. Ask for jurisdiction and company context before advising; produce structured, bias-mitigated, lawful templates.

*Source:* `/Users/elliesmith/.cursor/skills/skills/hr-pro/SKILL.md`

## `HTML Injection Testing`

**In chat:** `/html-injection-testing`

This skill should be used when the user asks to "test for HTML injection", "inject HTML into web pages", "perform HTML injection attacks", "deface web applications", or "test content injection vulnerabilities". It provides comprehensive HTML injection attack techniques and testing methodologies.

*Source:* `/Users/elliesmith/.cursor/skills/skills/html-injection-testing/SKILL.md`

## `hubspot-automation`

**In chat:** `/hubspot-automation`

"Automate HubSpot CRM operations (contacts, companies, deals, tickets, properties) via Rube MCP using Composio integration."

*Source:* `/Users/elliesmith/.cursor/skills/skills/hubspot-automation/SKILL.md`

## `hubspot-integration`

**In chat:** `/hubspot-integration`

"Expert patterns for HubSpot CRM integration including OAuth authentication, CRM objects, associations, batch operations, webhooks, and custom objects. Covers Node.js and Python SDKs. Use when: hubspot, hubspot api, hubspot crm, hubspot integration, contacts api."

*Source:* `/Users/elliesmith/.cursor/skills/skills/hubspot-integration/SKILL.md`

## `hugging-face-cli`

**In chat:** `/hugging-face-cli`

"Execute Hugging Face Hub operations using the `hf` CLI. Use when the user needs to download models/datasets/spaces, upload files to Hub repositories, create repos, manage local cache, or run compute jobs on HF infrastructure. Covers authentication, file transfers, repository creation, cache operations, and cloud compute."

*Source:* `/Users/elliesmith/.cursor/skills/skills/hugging-face-cli/SKILL.md`

## `hugging-face-jobs`

**In chat:** `/hugging-face-jobs`

"This skill should be used when users want to run any workload on Hugging Face Jobs infrastructure. Covers UV scripts, Docker-based jobs, hardware selection, cost estimation, authentication with tokens, secrets management, timeout configuration, and result persistence. Designed for general-purpose compute workloads including data processing, inference, experiments, batch jobs, and any Python-based tasks. Should be invoked for tasks involving cloud compute, GPU workloads, or when users mention running jobs on Hugging Face infrastructure without local setup."

*Source:* `/Users/elliesmith/.cursor/skills/skills/hugging-face-jobs/SKILL.md`

## `hybrid-cloud-architect`

**In chat:** `/hybrid-cloud-architect`

Expert hybrid cloud architect specializing in complex multi-cloud solutions across AWS/Azure/GCP and private clouds (OpenStack/VMware). Masters hybrid connectivity, workload placement optimization, edge computing, and cross-cloud automation. Handles compliance, cost optimization, disaster recovery, and migration strategies. Use PROACTIVELY for hybrid architecture, multi-cloud strategy, or complex infrastructure integration.

*Source:* `/Users/elliesmith/.cursor/skills/skills/hybrid-cloud-architect/SKILL.md`

## `hybrid-cloud-networking`

**In chat:** `/hybrid-cloud-networking`

Configure secure, high-performance connectivity between on-premises infrastructure and cloud platforms using VPN and dedicated connections. Use when building hybrid cloud architectures, connecting data centers to cloud, or implementing secure cross-premises networking.

*Source:* `/Users/elliesmith/.cursor/skills/skills/hybrid-cloud-networking/SKILL.md`

## `hybrid-search-implementation`

**In chat:** `/hybrid-search-implementation`

Combine vector and keyword search for improved retrieval. Use when implementing RAG systems, building search engines, or when neither approach alone provides sufficient recall.

*Source:* `/Users/elliesmith/.cursor/skills/skills/hybrid-search-implementation/SKILL.md`

## `i18n-localization`

**In chat:** `/i18n-localization`

Internationalization and localization patterns. Detecting hardcoded strings, managing translations, locale files, RTL support.

*Source:* `/Users/elliesmith/.cursor/skills/skills/i18n-localization/SKILL.md`

## `IDOR Vulnerability Testing`

**In chat:** `/idor-testing`

This skill should be used when the user asks to "test for insecure direct object references," "find IDOR vulnerabilities," "exploit broken access control," "enumerate user IDs or object references," or "bypass authorization to access other users' data." It provides comprehensive guidance for detecting, exploiting, and remediating IDOR vulnerabilities in web applications.

*Source:* `/Users/elliesmith/.cursor/skills/skills/idor-testing/SKILL.md`

## `imagegen`

**In chat:** `/imagegen`

"Generate or edit raster images when the task benefits from AI-created bitmap visuals such as photos, illustrations, textures, sprites, mockups, or transparent-background cutouts. Use when Codex should create a brand-new image, transform an existing image, or derive visual variants from references, and the output should be a bitmap asset rather than repo-native code or vector. Do not use when the task is better handled by editing existing SVG/vector/code-native assets, extending an established icon or logo system, or building the visual directly in HTML/CSS/canvas."

*Source:* `/Users/elliesmith/.codex/skills/.system/imagegen/SKILL.md`

## `imagen`

**In chat:** `/imagen`

*(no description in frontmatter)*

*Source:* `/Users/elliesmith/.cursor/skills/skills/imagen/SKILL.md`

## `incident-responder`

**In chat:** `/incident-responder`

Expert SRE incident responder specializing in rapid problem resolution, modern observability, and comprehensive incident management. Masters incident command, blameless post-mortems, error budget management, and system reliability patterns. Handles critical outages, communication strategies, and continuous improvement. Use IMMEDIATELY for production incidents or SRE practices.

*Source:* `/Users/elliesmith/.cursor/skills/skills/incident-responder/SKILL.md`

## `incident-response-incident-response`

**In chat:** `/incident-response-incident-response`

"Use when working with incident response incident response"

*Source:* `/Users/elliesmith/.cursor/skills/skills/incident-response-incident-response/SKILL.md`

## `incident-response-smart-fix`

**In chat:** `/incident-response-smart-fix`

"[Extended thinking: This workflow implements a sophisticated debugging and resolution pipeline that leverages AI-assisted debugging tools and observability platforms to systematically diagnose and res"

*Source:* `/Users/elliesmith/.cursor/skills/skills/incident-response-smart-fix/SKILL.md`

## `incident-runbook-templates`

**In chat:** `/incident-runbook-templates`

Create structured incident response runbooks with step-by-step procedures, escalation paths, and recovery actions. Use when building runbooks, responding to incidents, or establishing incident response procedures.

*Source:* `/Users/elliesmith/.cursor/skills/skills/incident-runbook-templates/SKILL.md`

## `Infinite Gratitude`

**In chat:** `/infinite-gratitude`

Multi-agent research skill for parallel research execution (10 agents, battle-tested with real case studies).

*Source:* `/Users/elliesmith/.cursor/skills/skills/infinite-gratitude/SKILL.md`

## `inngest`

**In chat:** `/inngest`

"Inngest expert for serverless-first background jobs, event-driven workflows, and durable execution without managing queues or workers. Use when: inngest, serverless background job, event-driven workflow, step function, durable execution."

*Source:* `/Users/elliesmith/.cursor/skills/skills/inngest/SKILL.md`

## `instagram-automation`

**In chat:** `/instagram-automation`

"Automate Instagram tasks via Rube MCP (Composio): create posts, carousels, manage media, get insights, and publishing limits. Always search tools first for current schemas."

*Source:* `/Users/elliesmith/.cursor/skills/skills/instagram-automation/SKILL.md`

## `interactive-portfolio`

**In chat:** `/interactive-portfolio`

"Expert in building portfolios that actually land jobs and clients - not just showing work, but creating memorable experiences. Covers developer portfolios, designer portfolios, creative portfolios, and portfolios that convert visitors into opportunities. Use when: portfolio, personal website, showcase work, developer portfolio, designer portfolio."

*Source:* `/Users/elliesmith/.cursor/skills/skills/interactive-portfolio/SKILL.md`

## `intercom-automation`

**In chat:** `/intercom-automation`

"Automate Intercom tasks via Rube MCP (Composio): conversations, contacts, companies, segments, admins. Always search tools first for current schemas."

*Source:* `/Users/elliesmith/.cursor/skills/skills/intercom-automation/SKILL.md`

## `internal-comms`

**In chat:** `/internal-comms-anthropic`

A set of resources to help me write all kinds of internal communications, using the formats that my company likes to use. Claude should use this skill whenever asked to write some sort of internal communications (status reports, leadership updates, 3P updates, company newsletters, FAQs, incident reports, project updates, etc.).

*Source:* `/Users/elliesmith/.cursor/skills/skills/internal-comms-anthropic/SKILL.md`

## `ios-developer`

**In chat:** `/ios-developer`

Develop native iOS applications with Swift/SwiftUI. Masters iOS 18, SwiftUI, UIKit integration, Core Data, networking, and App Store optimization. Use PROACTIVELY for iOS-specific features, App Store optimization, or native iOS development.

*Source:* `/Users/elliesmith/.cursor/skills/skills/ios-developer/SKILL.md`

## `istio-traffic-management`

**In chat:** `/istio-traffic-management`

Configure Istio traffic management including routing, load balancing, circuit breakers, and canary deployments. Use when implementing service mesh traffic policies, progressive delivery, or resilience patterns.

*Source:* `/Users/elliesmith/.cursor/skills/skills/istio-traffic-management/SKILL.md`

## `iterate-pr`

**In chat:** `/iterate-pr`

"Iterate on a PR until CI passes. Use when you need to fix CI failures, address review feedback, or continuously push fixes until all checks are green. Automates the feedback-fix-push-wait cycle."

*Source:* `/Users/elliesmith/.cursor/skills/skills/iterate-pr/SKILL.md`

## `java-pro`

**In chat:** `/java-pro`

Master Java 21+ with modern features like virtual threads, pattern matching, and Spring Boot 3.x. Expert in the latest Java ecosystem including GraalVM, Project Loom, and cloud-native patterns. Use PROACTIVELY for Java development, microservices architecture, or performance optimization.

*Source:* `/Users/elliesmith/.cursor/skills/skills/java-pro/SKILL.md`

## `javascript-mastery`

**In chat:** `/javascript-mastery`

"Comprehensive JavaScript reference covering 33+ essential concepts every developer should know. From fundamentals like primitives and closures to advanced patterns like async/await and functional programming. Use when explaining JS concepts, debugging JavaScript issues, or teaching JavaScript fundamentals."

*Source:* `/Users/elliesmith/.cursor/skills/skills/javascript-mastery/SKILL.md`

## `javascript-pro`

**In chat:** `/javascript-pro`

Master modern JavaScript with ES6+, async patterns, and Node.js APIs. Handles promises, event loops, and browser/Node compatibility. Use PROACTIVELY for JavaScript optimization, async debugging, or complex JS patterns.

*Source:* `/Users/elliesmith/.cursor/skills/skills/javascript-pro/SKILL.md`

## `javascript-testing-patterns`

**In chat:** `/javascript-testing-patterns`

Implement comprehensive testing strategies using Jest, Vitest, and Testing Library for unit tests, integration tests, and end-to-end testing with mocking, fixtures, and test-driven development. Use when writing JavaScript/TypeScript tests, setting up test infrastructure, or implementing TDD/BDD workflows.

*Source:* `/Users/elliesmith/.cursor/skills/skills/javascript-testing-patterns/SKILL.md`

## `javascript-typescript-typescript-scaffold`

**In chat:** `/javascript-typescript-typescript-scaffold`

"You are a TypeScript project architecture expert specializing in scaffolding production-ready Node.js and frontend applications. Generate complete project structures with modern tooling (pnpm, Vite, N"

*Source:* `/Users/elliesmith/.cursor/skills/skills/javascript-typescript-typescript-scaffold/SKILL.md`

## `jira-automation`

**In chat:** `/jira-automation`

"Automate Jira tasks via Rube MCP (Composio): issues, projects, sprints, boards, comments, users. Always search tools first for current schemas."

*Source:* `/Users/elliesmith/.cursor/skills/skills/jira-automation/SKILL.md`

## `julia-pro`

**In chat:** `/julia-pro`

Master Julia 1.10+ with modern features, performance optimization, multiple dispatch, and production-ready practices. Expert in the Julia ecosystem including package management, scientific computing, and high-performance numerical code. Use PROACTIVELY for Julia development, optimization, or advanced Julia patterns.

*Source:* `/Users/elliesmith/.cursor/skills/skills/julia-pro/SKILL.md`

## `k8s-manifest-generator`

**In chat:** `/k8s-manifest-generator`

Create production-ready Kubernetes manifests for Deployments, Services, ConfigMaps, and Secrets following best practices and security standards. Use when generating Kubernetes YAML manifests, creating K8s resources, or implementing production-grade Kubernetes configurations.

*Source:* `/Users/elliesmith/.cursor/skills/skills/k8s-manifest-generator/SKILL.md`

## `k8s-security-policies`

**In chat:** `/k8s-security-policies`

Implement Kubernetes security policies including NetworkPolicy, PodSecurityPolicy, and RBAC for production-grade security. Use when securing Kubernetes clusters, implementing network isolation, or enforcing pod security standards.

*Source:* `/Users/elliesmith/.cursor/skills/skills/k8s-security-policies/SKILL.md`

## `kaizen`

**In chat:** `/kaizen`

Guide for continuous improvement, error proofing, and standardization. Use this skill when the user wants to improve code quality, refactor, or discuss process improvements.

*Source:* `/Users/elliesmith/.cursor/skills/skills/kaizen/SKILL.md`

## `klaviyo-automation`

**In chat:** `/klaviyo-automation`

"Automate Klaviyo tasks via Rube MCP (Composio): manage email/SMS campaigns, inspect campaign messages, track tags, and monitor send jobs. Always search tools first for current schemas."

*Source:* `/Users/elliesmith/.cursor/skills/skills/klaviyo-automation/SKILL.md`

## `kpi-dashboard-design`

**In chat:** `/kpi-dashboard-design`

Design effective KPI dashboards with metrics selection, visualization best practices, and real-time monitoring patterns. Use when building business dashboards, selecting metrics, or designing data visualization layouts.

*Source:* `/Users/elliesmith/.cursor/skills/skills/kpi-dashboard-design/SKILL.md`

## `kubernetes-architect`

**In chat:** `/kubernetes-architect`

Expert Kubernetes architect specializing in cloud-native infrastructure, advanced GitOps workflows (ArgoCD/Flux), and enterprise container orchestration. Masters EKS/AKS/GKE, service mesh (Istio/Linkerd), progressive delivery, multi-tenancy, and platform engineering. Handles security, observability, cost optimization, and developer experience. Use PROACTIVELY for K8s architecture, GitOps implementation, or cloud-native platform design.

*Source:* `/Users/elliesmith/.cursor/skills/skills/kubernetes-architect/SKILL.md`

## `langchain-architecture`

**In chat:** `/langchain-architecture`

Design LLM applications using the LangChain framework with agents, memory, and tool integration patterns. Use when building LangChain applications, implementing AI agents, or creating complex LLM workflows.

*Source:* `/Users/elliesmith/.cursor/skills/skills/langchain-architecture/SKILL.md`

## `langfuse`

**In chat:** `/langfuse`

"Expert in Langfuse - the open-source LLM observability platform. Covers tracing, prompt management, evaluation, datasets, and integration with LangChain, LlamaIndex, and OpenAI. Essential for debugging, monitoring, and improving LLM applications in production. Use when: langfuse, llm observability, llm tracing, prompt management, llm evaluation."

*Source:* `/Users/elliesmith/.cursor/skills/skills/langfuse/SKILL.md`

## `langgraph`

**In chat:** `/langgraph`

"Expert in LangGraph - the production-grade framework for building stateful, multi-actor AI applications. Covers graph construction, state management, cycles and branches, persistence with checkpointers, human-in-the-loop patterns, and the ReAct agent pattern. Used in production at LinkedIn, Uber, and 400+ companies. This is LangChain's recommended approach for building agents. Use when: langgraph, langchain agent, stateful agent, agent graph, react agent."

*Source:* `/Users/elliesmith/.cursor/skills/skills/langgraph/SKILL.md`

## `laravel-expert`

**In chat:** `/laravel-expert`

Senior Laravel Engineer role for production-grade, maintainable, and idiomatic Laravel solutions. Focuses on clean architecture, security, performance, and modern standards (Laravel 10/11+).

*Source:* `/Users/elliesmith/.cursor/skills/skills/laravel-expert/SKILL.md`

## `laravel-security-audit`

**In chat:** `/laravel-security-audit`

Security auditor for Laravel applications. Analyzes code for vulnerabilities, misconfigurations, and insecure practices using OWASP standards and Laravel security best practices.

*Source:* `/Users/elliesmith/.cursor/skills/skills/laravel-security-audit/SKILL.md`

## `last30days`

**In chat:** `/last30days`

Research a topic from the last 30 days on Reddit + X + Web, become an expert, and write copy-paste-ready prompts for the user's target tool.

*Source:* `/Users/elliesmith/.cursor/skills/skills/last30days/SKILL.md`

## `launch-strategy`

**In chat:** `/launch-strategy`

"When the user wants to plan a product launch, feature announcement, or release strategy. Also use when the user mentions 'launch,' 'Product Hunt,' 'feature release,' 'announcement,' 'go-to-market,' 'beta launch,' 'early access,' 'waitlist,' or 'product update.' This skill covers phased launches, channel strategy, and ongoing launch momentum."

*Source:* `/Users/elliesmith/.cursor/skills/skills/launch-strategy/SKILL.md`

## `legacy-modernizer`

**In chat:** `/legacy-modernizer`

Refactor legacy codebases, migrate outdated frameworks, and implement gradual modernization. Handles technical debt, dependency updates, and backward compatibility. Use PROACTIVELY for legacy system updates, framework migrations, or technical debt reduction.

*Source:* `/Users/elliesmith/.cursor/skills/skills/legacy-modernizer/SKILL.md`

## `legal-advisor`

**In chat:** `/legal-advisor`

Draft privacy policies, terms of service, disclaimers, and legal notices. Creates GDPR-compliant texts, cookie policies, and data processing agreements. Use PROACTIVELY for legal documentation, compliance texts, or regulatory requirements.

*Source:* `/Users/elliesmith/.cursor/skills/skills/legal-advisor/SKILL.md`

## `linear-automation`

**In chat:** `/linear-automation`

"Automate Linear tasks via Rube MCP (Composio): issues, projects, cycles, teams, labels. Always search tools first for current schemas."

*Source:* `/Users/elliesmith/.cursor/skills/skills/linear-automation/SKILL.md`

## `linear-claude-skill`

**In chat:** `/linear-claude-skill`

"Manage Linear issues, projects, and teams"

*Source:* `/Users/elliesmith/.cursor/skills/skills/linear-claude-skill/SKILL.md`

## `linkedin-automation`

**In chat:** `/linkedin-automation`

"Automate LinkedIn tasks via Rube MCP (Composio): create posts, manage profile, company info, comments, and image uploads. Always search tools first for current schemas."

*Source:* `/Users/elliesmith/.cursor/skills/skills/linkedin-automation/SKILL.md`

## `linkerd-patterns`

**In chat:** `/linkerd-patterns`

Implement Linkerd service mesh patterns for lightweight, security-focused service mesh deployments. Use when setting up Linkerd, configuring traffic policies, or implementing zero-trust networking with minimal overhead.

*Source:* `/Users/elliesmith/.cursor/skills/skills/linkerd-patterns/SKILL.md`

## `lint-and-validate`

**In chat:** `/lint-and-validate`

"Automatic quality control, linting, and static analysis procedures. Use after every code modification to ensure syntax correctness and project standards. Triggers onKeywords: lint, format, check, validate, types, static analysis."

*Source:* `/Users/elliesmith/.cursor/skills/skills/lint-and-validate/SKILL.md`

## `Linux Privilege Escalation`

**In chat:** `/linux-privilege-escalation`

This skill should be used when the user asks to "escalate privileges on Linux", "find privesc vectors on Linux systems", "exploit sudo misconfigurations", "abuse SUID binaries", "exploit cron jobs for root access", "enumerate Linux systems for privilege escalation", or "gain root access from low-privilege shell". It provides comprehensive techniques for identifying and exploiting privilege escalation paths on Linux systems.

*Source:* `/Users/elliesmith/.cursor/skills/skills/linux-privilege-escalation/SKILL.md`

## `Linux Production Shell Scripts`

**In chat:** `/linux-shell-scripting`

This skill should be used when the user asks to "create bash scripts", "automate Linux tasks", "monitor system resources", "backup files", "manage users", or "write production shell scripts". It provides ready-to-use shell script templates for system administration.

*Source:* `/Users/elliesmith/.cursor/skills/skills/linux-shell-scripting/SKILL.md`

## `llm-app-patterns`

**In chat:** `/llm-app-patterns`

"Production-ready patterns for building LLM applications. Covers RAG pipelines, agent architectures, prompt IDEs, and LLMOps monitoring. Use when designing AI applications, implementing RAG, building agents, or setting up LLM observability."

*Source:* `/Users/elliesmith/.cursor/skills/skills/llm-app-patterns/SKILL.md`

## `llm-application-dev-ai-assistant`

**In chat:** `/llm-application-dev-ai-assistant`

"You are an AI assistant development expert specializing in creating intelligent conversational interfaces, chatbots, and AI-powered applications. Design comprehensive AI assistant solutions with natur"

*Source:* `/Users/elliesmith/.cursor/skills/skills/llm-application-dev-ai-assistant/SKILL.md`

## `llm-application-dev-langchain-agent`

**In chat:** `/llm-application-dev-langchain-agent`

"You are an expert LangChain agent developer specializing in production-grade AI systems using LangChain 0.1+ and LangGraph."

*Source:* `/Users/elliesmith/.cursor/skills/skills/llm-application-dev-langchain-agent/SKILL.md`

## `llm-application-dev-prompt-optimize`

**In chat:** `/llm-application-dev-prompt-optimize`

"You are an expert prompt engineer specializing in crafting effective prompts for LLMs through advanced techniques including constitutional AI, chain-of-thought reasoning, and model-specific optimizati"

*Source:* `/Users/elliesmith/.cursor/skills/skills/llm-application-dev-prompt-optimize/SKILL.md`

## `llm-evaluation`

**In chat:** `/llm-evaluation`

Implement comprehensive evaluation strategies for LLM applications using automated metrics, human feedback, and benchmarking. Use when testing LLM performance, measuring AI application quality, or establishing evaluation frameworks.

*Source:* `/Users/elliesmith/.cursor/skills/skills/llm-evaluation/SKILL.md`

## `loki-mode`

**In chat:** `/loki-mode`

Multi-agent autonomous startup system for Claude Code. Triggers on "Loki Mode". Orchestrates 100+ specialized agents across engineering, QA, DevOps, security, data/ML, business operations, marketing, HR, and customer success. Takes PRD to fully deployed, revenue-generating product with zero human intervention. Features Task tool for subagent dispatch, parallel code review with 3 specialized reviewers, severity-based issue triage, distributed task queue with dead letter handling, automatic deployment to cloud providers, A/B testing, customer feedback loops, incident response, circuit breakers, and self-healing. Handles rate limits via distributed state checkpoints and auto-resume with exponential backoff. Requires --dangerously-skip-permissions flag.

*Source:* `/Users/elliesmith/.cursor/skills/skills/loki-mode/SKILL.md`

## `m365-agents-dotnet`

**In chat:** `/m365-agents-dotnet`

Microsoft 365 Agents SDK for .NET. Build multichannel agents for Teams/M365/Copilot Studio with ASP.NET Core hosting, AgentApplication routing, and MSAL-based auth. Triggers: "Microsoft 365 Agents SDK", "Microsoft.Agents", "AddAgentApplicationOptions", "AgentApplication", "AddAgentAspNetAuthentication", "Copilot Studio client", "IAgentHttpAdapter".

*Source:* `/Users/elliesmith/.cursor/skills/skills/m365-agents-dotnet/SKILL.md`

## `m365-agents-py`

**In chat:** `/m365-agents-py`

Microsoft 365 Agents SDK for Python. Build multichannel agents for Teams/M365/Copilot Studio with aiohttp hosting, AgentApplication routing, streaming responses, and MSAL-based auth. Triggers: "Microsoft 365 Agents SDK", "microsoft_agents", "AgentApplication", "start_agent_process", "TurnContext", "Copilot Studio client", "CloudAdapter".

*Source:* `/Users/elliesmith/.cursor/skills/skills/m365-agents-py/SKILL.md`

## `m365-agents-ts`

**In chat:** `/m365-agents-ts`

Microsoft 365 Agents SDK for TypeScript/Node.js. Build multichannel agents for Teams/M365/Copilot Studio with AgentApplication routing, Express hosting, streaming responses, and Copilot Studio client integration. Triggers: "Microsoft 365 Agents SDK", "@microsoft/agents-hosting", "AgentApplication", "startServer", "streamingResponse", "Copilot Studio client", "@microsoft/agents-copilotstudio-client".

*Source:* `/Users/elliesmith/.cursor/skills/skills/m365-agents-ts/SKILL.md`

## `machine-learning-ops-ml-pipeline`

**In chat:** `/machine-learning-ops-ml-pipeline`

"Design and implement a complete ML pipeline for: $ARGUMENTS"

*Source:* `/Users/elliesmith/.cursor/skills/skills/machine-learning-ops-ml-pipeline/SKILL.md`

## `mailchimp-automation`

**In chat:** `/mailchimp-automation`

"Automate Mailchimp email marketing including campaigns, audiences, subscribers, segments, and analytics via Rube MCP (Composio). Always search tools first for current schemas."

*Source:* `/Users/elliesmith/.cursor/skills/skills/mailchimp-automation/SKILL.md`

## `make-automation`

**In chat:** `/make-automation`

"Automate Make (Integromat) tasks via Rube MCP (Composio): operations, enums, language and timezone lookups. Always search tools first for current schemas."

*Source:* `/Users/elliesmith/.cursor/skills/skills/make-automation/SKILL.md`

## `makepad-skills`

**In chat:** `/makepad-skills`

"Makepad UI development skills for Rust apps: setup, patterns, shaders, packaging, and troubleshooting."

*Source:* `/Users/elliesmith/.cursor/skills/skills/makepad-skills/SKILL.md`

## `malware-analyst`

**In chat:** `/malware-analyst`

Expert malware analyst specializing in defensive malware research, threat intelligence, and incident response. Masters sandbox analysis, behavioral analysis, and malware family identification. Handles static/dynamic analysis, unpacking, and IOC extraction. Use PROACTIVELY for malware triage, threat hunting, incident response, or security research.

*Source:* `/Users/elliesmith/.cursor/skills/skills/malware-analyst/SKILL.md`

## `market-sizing-analysis`

**In chat:** `/market-sizing-analysis`

This skill should be used when the user asks to "calculate TAM", "determine SAM", "estimate SOM", "size the market", "calculate market opportunity", "what's the total addressable market", or requests market sizing analysis for a startup or business opportunity.

*Source:* `/Users/elliesmith/.cursor/skills/skills/market-sizing-analysis/SKILL.md`

## `marketing-ideas`

**In chat:** `/marketing-ideas`

Provide proven marketing strategies and growth ideas for SaaS and software products, prioritized using a marketing feasibility scoring system.

*Source:* `/Users/elliesmith/.cursor/skills/skills/marketing-ideas/SKILL.md`

## `marketing-psychology`

**In chat:** `/marketing-psychology`

Apply behavioral science and mental models to marketing decisions, prioritized using a psychological leverage and feasibility scoring system.

*Source:* `/Users/elliesmith/.cursor/skills/skills/marketing-psychology/SKILL.md`

## `mcp-builder`

**In chat:** `/mcp-builder-ms`

Guide for creating high-quality MCP (Model Context Protocol) servers that enable LLMs to interact with external services through well-designed tools. Use when building MCP servers to integrate external APIs or services, whether in Python (FastMCP), Node/TypeScript (MCP SDK), or C#/.NET (Microsoft MCP SDK).

*Source:* `/Users/elliesmith/.cursor/skills/skills/mcp-builder-ms/SKILL.md`

## `memory-forensics`

**In chat:** `/memory-forensics`

Master memory forensics techniques including memory acquisition, process analysis, and artifact extraction using Volatility and related tools. Use when analyzing memory dumps, investigating incidents, or performing malware analysis from RAM captures.

*Source:* `/Users/elliesmith/.cursor/skills/skills/memory-forensics/SKILL.md`

## `memory-safety-patterns`

**In chat:** `/memory-safety-patterns`

Implement memory-safe programming with RAII, ownership, smart pointers, and resource management across Rust, C++, and C. Use when writing safe systems code, managing resources, or preventing memory bugs.

*Source:* `/Users/elliesmith/.cursor/skills/skills/memory-safety-patterns/SKILL.md`

## `memory-systems`

**In chat:** `/memory-systems`

"Design short-term, long-term, and graph-based memory architectures"

*Source:* `/Users/elliesmith/.cursor/skills/skills/memory-systems/SKILL.md`

## `mermaid-expert`

**In chat:** `/mermaid-expert`

Create Mermaid diagrams for flowcharts, sequences, ERDs, and architectures. Masters syntax for all diagram types and styling. Use PROACTIVELY for visual documentation, system diagrams, or process flows.

*Source:* `/Users/elliesmith/.cursor/skills/skills/mermaid-expert/SKILL.md`

## `Metasploit Framework`

**In chat:** `/metasploit-framework`

This skill should be used when the user asks to "use Metasploit for penetration testing", "exploit vulnerabilities with msfconsole", "create payloads with msfvenom", "perform post-exploitation", "use auxiliary modules for scanning", or "develop custom exploits". It provides comprehensive guidance for leveraging the Metasploit Framework in security assessments.

*Source:* `/Users/elliesmith/.cursor/skills/skills/metasploit-framework/SKILL.md`

## `micro-saas-launcher`

**In chat:** `/micro-saas-launcher`

"Expert in launching small, focused SaaS products fast - the indie hacker approach to building profitable software. Covers idea validation, MVP development, pricing, launch strategies, and growing to sustainable revenue. Ship in weeks, not months. Use when: micro saas, indie hacker, small saas, side project, saas mvp."

*Source:* `/Users/elliesmith/.cursor/skills/skills/micro-saas-launcher/SKILL.md`

## `microservices-patterns`

**In chat:** `/microservices-patterns`

Design microservices architectures with service boundaries, event-driven communication, and resilience patterns. Use when building distributed systems, decomposing monoliths, or implementing microservices.

*Source:* `/Users/elliesmith/.cursor/skills/skills/microservices-patterns/SKILL.md`

## `microsoft-azure-webjobs-extensions-authentication-events-dotnet`

**In chat:** `/microsoft-azure-webjobs-extensions-authentication-events-dotnet`

Microsoft Entra Authentication Events SDK for .NET. Azure Functions triggers for custom authentication extensions. Use for token enrichment, custom claims, attribute collection, and OTP customization in Entra ID. Triggers: "Authentication Events", "WebJobsAuthenticationEventsTrigger", "OnTokenIssuanceStart", "OnAttributeCollectionStart", "custom claims", "token enrichment", "Entra custom extension", "authentication extension".

*Source:* `/Users/elliesmith/.cursor/skills/skills/microsoft-azure-webjobs-extensions-authentication-events-dotnet/SKILL.md`

## `microsoft-teams-automation`

**In chat:** `/microsoft-teams-automation`

"Automate Microsoft Teams tasks via Rube MCP (Composio): send messages, manage channels, create meetings, handle chats, and search messages. Always search tools first for current schemas."

*Source:* `/Users/elliesmith/.cursor/skills/skills/microsoft-teams-automation/SKILL.md`

## `migrate-to-skills`

**In chat:** `/migrate-to-skills`

Convert 'Applied intelligently' Cursor rules (.cursor/rules/*.mdc) and slash commands (.cursor/commands/*.md) to Agent Skills format (.cursor/skills/). Use when you want to migrate rules or commands to skills, convert .mdc rules to SKILL.md format, or consolidate commands into the skills directory.

*Source:* `/Users/elliesmith/.cursor/skills-cursor/migrate-to-skills/SKILL.md`

## `minecraft-bukkit-pro`

**In chat:** `/minecraft-bukkit-pro`

Master Minecraft server plugin development with Bukkit, Spigot, and Paper APIs. Specializes in event-driven architecture, command systems, world manipulation, player management, and performance optimization. Use PROACTIVELY for plugin architecture, gameplay mechanics, server-side features, or cross-version compatibility.

*Source:* `/Users/elliesmith/.cursor/skills/skills/minecraft-bukkit-pro/SKILL.md`

## `miro-automation`

**In chat:** `/miro-automation`

"Automate Miro tasks via Rube MCP (Composio): boards, items, sticky notes, frames, sharing, connectors. Always search tools first for current schemas."

*Source:* `/Users/elliesmith/.cursor/skills/skills/miro-automation/SKILL.md`

## `mixpanel-automation`

**In chat:** `/mixpanel-automation`

"Automate Mixpanel tasks via Rube MCP (Composio): events, segmentation, funnels, cohorts, user profiles, JQL queries. Always search tools first for current schemas."

*Source:* `/Users/elliesmith/.cursor/skills/skills/mixpanel-automation/SKILL.md`

## `ml-engineer`

**In chat:** `/ml-engineer`

Build production ML systems with PyTorch 2.x, TensorFlow, and modern ML frameworks. Implements model serving, feature engineering, A/B testing, and monitoring. Use PROACTIVELY for ML model deployment, inference optimization, or production ML infrastructure.

*Source:* `/Users/elliesmith/.cursor/skills/skills/ml-engineer/SKILL.md`

## `ml-pipeline-workflow`

**In chat:** `/ml-pipeline-workflow`

Build end-to-end MLOps pipelines from data preparation through model training, validation, and production deployment. Use when creating ML pipelines, implementing MLOps practices, or automating model training and deployment workflows.

*Source:* `/Users/elliesmith/.cursor/skills/skills/ml-pipeline-workflow/SKILL.md`

## `mlops-engineer`

**In chat:** `/mlops-engineer`

Build comprehensive ML pipelines, experiment tracking, and model registries with MLflow, Kubeflow, and modern MLOps tools. Implements automated training, deployment, and monitoring across cloud platforms. Use PROACTIVELY for ML infrastructure, experiment management, or pipeline automation.

*Source:* `/Users/elliesmith/.cursor/skills/skills/mlops-engineer/SKILL.md`

## `mobile-design`

**In chat:** `/mobile-design`

Mobile-first design and engineering doctrine for iOS and Android apps. Covers touch interaction, performance, platform conventions, offline behavior, and mobile-specific decision-making. Teaches principles and constraints, not fixed layouts. Use for React Native, Flutter, or native mobile apps.

*Source:* `/Users/elliesmith/.cursor/skills/skills/mobile-design/SKILL.md`

## `mobile-developer`

**In chat:** `/mobile-developer`

Develop React Native, Flutter, or native mobile apps with modern architecture patterns. Masters cross-platform development, native integrations, offline sync, and app store optimization. Use PROACTIVELY for mobile features, cross-platform code, or app optimization.

*Source:* `/Users/elliesmith/.cursor/skills/skills/mobile-developer/SKILL.md`

## `mobile-games`

**In chat:** `/mobile-games`

Mobile game development principles. Touch input, battery, performance, app stores.

*Source:* `/Users/elliesmith/.cursor/skills/skills/game-development/mobile-games/SKILL.md`

## `mobile-security-coder`

**In chat:** `/mobile-security-coder`

Expert in secure mobile coding practices specializing in input validation, WebView security, and mobile-specific security patterns. Use PROACTIVELY for mobile security implementations or mobile security code reviews.

*Source:* `/Users/elliesmith/.cursor/skills/skills/mobile-security-coder/SKILL.md`

## `modern-javascript-patterns`

**In chat:** `/modern-javascript-patterns`

Master ES6+ features including async/await, destructuring, spread operators, arrow functions, promises, modules, iterators, generators, and functional programming patterns for writing clean, efficient JavaScript code. Use when refactoring legacy code, implementing modern patterns, or optimizing JavaScript applications.

*Source:* `/Users/elliesmith/.cursor/skills/skills/modern-javascript-patterns/SKILL.md`

## `monday-automation`

**In chat:** `/monday-automation`

"Automate Monday.com work management including boards, items, columns, groups, subitems, and updates via Rube MCP (Composio). Always search tools first for current schemas."

*Source:* `/Users/elliesmith/.cursor/skills/skills/monday-automation/SKILL.md`

## `monorepo-architect`

**In chat:** `/monorepo-architect`

"Expert in monorepo architecture, build systems, and dependency management at scale. Masters Nx, Turborepo, Bazel, and Lerna for efficient multi-project development. Use PROACTIVELY for monorepo setup,"

*Source:* `/Users/elliesmith/.cursor/skills/skills/monorepo-architect/SKILL.md`

## `monorepo-management`

**In chat:** `/monorepo-management`

Master monorepo management with Turborepo, Nx, and pnpm workspaces to build efficient, scalable multi-package repositories with optimized builds and dependency management. Use when setting up monorepos, optimizing builds, or managing shared dependencies.

*Source:* `/Users/elliesmith/.cursor/skills/skills/monorepo-management/SKILL.md`

## `moodle-external-api-development`

**In chat:** `/moodle-external-api-development`

Create custom external web service APIs for Moodle LMS. Use when implementing web services for course management, user tracking, quiz operations, or custom plugin functionality. Covers parameter validation, database operations, error handling, service registration, and Moodle coding standards.

*Source:* `/Users/elliesmith/.cursor/skills/skills/moodle-external-api-development/SKILL.md`

## `mtls-configuration`

**In chat:** `/mtls-configuration`

Configure mutual TLS (mTLS) for zero-trust service-to-service communication. Use when implementing zero-trust networking, certificate management, or securing internal service communication.

*Source:* `/Users/elliesmith/.cursor/skills/skills/mtls-configuration/SKILL.md`

## `multi-agent-brainstorming`

**In chat:** `/multi-agent-brainstorming`

Use this skill when a design or idea requires higher confidence, risk reduction, or formal review. This skill orchestrates a structured, sequential multi-agent design review where each agent has a strict, non-overlapping role. It prevents blind spots, false confidence, and premature convergence.

*Source:* `/Users/elliesmith/.cursor/skills/skills/multi-agent-brainstorming/SKILL.md`

## `multi-agent-patterns`

**In chat:** `/multi-agent-patterns`

"Master orchestrator, peer-to-peer, and hierarchical multi-agent architectures"

*Source:* `/Users/elliesmith/.cursor/skills/skills/multi-agent-patterns/SKILL.md`

## `multi-cloud-architecture`

**In chat:** `/multi-cloud-architecture`

Design multi-cloud architectures using a decision framework to select and integrate services across AWS, Azure, and GCP. Use when building multi-cloud systems, avoiding vendor lock-in, or leveraging best-of-breed services from multiple providers.

*Source:* `/Users/elliesmith/.cursor/skills/skills/multi-cloud-architecture/SKILL.md`

## `multi-platform-apps-multi-platform`

**In chat:** `/multi-platform-apps-multi-platform`

"Build and deploy the same feature consistently across web, mobile, and desktop platforms using API-first architecture and parallel implementation strategies."

*Source:* `/Users/elliesmith/.cursor/skills/skills/multi-platform-apps-multi-platform/SKILL.md`

## `multiplayer`

**In chat:** `/multiplayer`

Multiplayer game development principles. Architecture, networking, synchronization.

*Source:* `/Users/elliesmith/.cursor/skills/skills/game-development/multiplayer/SKILL.md`

## `n8n-code-python`

**In chat:** `/n8n-code-python`

"Write Python code in n8n Code nodes. Use when writing Python in n8n, using _input/_json/_node syntax, working with standard library, or need to understand Python limitations in n8n Code nodes."

*Source:* `/Users/elliesmith/.cursor/skills/skills/n8n-code-python/SKILL.md`

## `n8n-mcp-tools-expert`

**In chat:** `/n8n-mcp-tools-expert`

"Expert guide for using n8n-mcp MCP tools effectively. Use when searching for nodes, validating configurations, accessing templates, managing workflows, or using any n8n-mcp tool. Provides tool selection guidance, parameter formats, and common patterns."

*Source:* `/Users/elliesmith/.cursor/skills/skills/n8n-mcp-tools-expert/SKILL.md`

## `n8n-node-configuration`

**In chat:** `/n8n-node-configuration`

"Operation-aware node configuration guidance. Use when configuring nodes, understanding property dependencies, determining required fields, choosing between get_node detail levels, or learning common configuration patterns by node type."

*Source:* `/Users/elliesmith/.cursor/skills/skills/n8n-node-configuration/SKILL.md`

## `nanobanana-ppt-skills`

**In chat:** `/nanobanana-ppt-skills`

"AI-powered PPT generation with document analysis and styled images"

*Source:* `/Users/elliesmith/.cursor/skills/skills/nanobanana-ppt-skills/SKILL.md`

## `neon-postgres`

**In chat:** `/neon-postgres`

"Expert patterns for Neon serverless Postgres, branching, connection pooling, and Prisma/Drizzle integration Use when: neon database, serverless postgres, database branching, neon postgres, postgres serverless."

*Source:* `/Users/elliesmith/.cursor/skills/skills/neon-postgres/SKILL.md`

## `nestjs-expert`

**In chat:** `/nestjs-expert`

Nest.js framework expert specializing in module architecture, dependency injection, middleware, guards, interceptors, testing with Jest/Supertest, TypeORM/Mongoose integration, and Passport.js authentication. Use PROACTIVELY for any Nest.js application issues including architecture decisions, testing strategies, performance optimization, or debugging complex dependency injection problems. If a specialized expert is a better fit, I will recommend switching and stop.

*Source:* `/Users/elliesmith/.cursor/skills/skills/nestjs-expert/SKILL.md`

## `Network 101`

**In chat:** `/network-101`

This skill should be used when the user asks to "set up a web server", "configure HTTP or HTTPS", "perform SNMP enumeration", "configure SMB shares", "test network services", or needs guidance on configuring and testing network services for penetration testing labs.

*Source:* `/Users/elliesmith/.cursor/skills/skills/network-101/SKILL.md`

## `network-engineer`

**In chat:** `/network-engineer`

Expert network engineer specializing in modern cloud networking, security architectures, and performance optimization. Masters multi-cloud connectivity, service mesh, zero-trust networking, SSL/TLS, global load balancing, and advanced troubleshooting. Handles CDN optimization, network automation, and compliance. Use PROACTIVELY for network design, connectivity issues, or performance optimization.

*Source:* `/Users/elliesmith/.cursor/skills/skills/network-engineer/SKILL.md`

## `nextjs-app-router-patterns`

**In chat:** `/nextjs-app-router-patterns`

Master Next.js 14+ App Router with Server Components, streaming, parallel routes, and advanced data fetching. Use when building Next.js applications, implementing SSR/SSG, or optimizing React Server Components.

*Source:* `/Users/elliesmith/.cursor/skills/skills/nextjs-app-router-patterns/SKILL.md`

## `nextjs-best-practices`

**In chat:** `/nextjs-best-practices`

Next.js App Router principles. Server Components, data fetching, routing patterns.

*Source:* `/Users/elliesmith/.cursor/skills/skills/nextjs-best-practices/SKILL.md`

## `nextjs-supabase-auth`

**In chat:** `/nextjs-supabase-auth`

"Expert integration of Supabase Auth with Next.js App Router Use when: supabase auth next, authentication next.js, login supabase, auth middleware, protected route."

*Source:* `/Users/elliesmith/.cursor/skills/skills/nextjs-supabase-auth/SKILL.md`

## `nft-standards`

**In chat:** `/nft-standards`

Implement NFT standards (ERC-721, ERC-1155) with proper metadata handling, minting strategies, and marketplace integration. Use when creating NFT contracts, building NFT marketplaces, or implementing digital asset systems.

*Source:* `/Users/elliesmith/.cursor/skills/skills/nft-standards/SKILL.md`

## `nodejs-backend-patterns`

**In chat:** `/nodejs-backend-patterns`

Build production-ready Node.js backend services with Express/Fastify, implementing middleware patterns, error handling, authentication, database integration, and API design best practices. Use when creating Node.js servers, REST APIs, GraphQL backends, or microservices architectures.

*Source:* `/Users/elliesmith/.cursor/skills/skills/nodejs-backend-patterns/SKILL.md`

## `nodejs-best-practices`

**In chat:** `/nodejs-best-practices`

Node.js development principles and decision-making. Framework selection, async patterns, security, and architecture. Teaches thinking, not copying.

*Source:* `/Users/elliesmith/.cursor/skills/skills/nodejs-best-practices/SKILL.md`

## `nosql-expert`

**In chat:** `/nosql-expert`

"Expert guidance for distributed NoSQL databases (Cassandra, DynamoDB). Focuses on mental models, query-first modeling, single-table design, and avoiding hot partitions in high-scale systems."

*Source:* `/Users/elliesmith/.cursor/skills/skills/nosql-expert/SKILL.md`

## `notebooklm`

**In chat:** `/notebooklm`

Use this skill to query your Google NotebookLM notebooks directly from Claude Code for source-grounded, citation-backed answers from Gemini. Browser automation, library management, persistent auth. Drastically reduced hallucinations through document-only responses.

*Source:* `/Users/elliesmith/.cursor/skills/skills/notebooklm/SKILL.md`

## `notion-automation`

**In chat:** `/notion-automation`

"Automate Notion tasks via Rube MCP (Composio): pages, databases, blocks, comments, users. Always search tools first for current schemas."

*Source:* `/Users/elliesmith/.cursor/skills/skills/notion-automation/SKILL.md`

## `notion-template-business`

**In chat:** `/notion-template-business`

"Expert in building and selling Notion templates as a business - not just making templates, but building a sustainable digital product business. Covers template design, pricing, marketplaces, marketing, and scaling to real revenue. Use when: notion template, sell templates, digital product, notion business, gumroad."

*Source:* `/Users/elliesmith/.cursor/skills/skills/notion-template-business/SKILL.md`

## `nx-workspace-patterns`

**In chat:** `/nx-workspace-patterns`

Configure and optimize Nx monorepo workspaces. Use when setting up Nx, configuring project boundaries, optimizing build caching, or implementing affected commands.

*Source:* `/Users/elliesmith/.cursor/skills/skills/nx-workspace-patterns/SKILL.md`

## `observability-engineer`

**In chat:** `/observability-engineer`

Build production-ready monitoring, logging, and tracing systems. Implements comprehensive observability strategies, SLI/SLO management, and incident response workflows. Use PROACTIVELY for monitoring infrastructure, performance optimization, or production reliability.

*Source:* `/Users/elliesmith/.cursor/skills/skills/observability-engineer/SKILL.md`

## `observability-monitoring-monitor-setup`

**In chat:** `/observability-monitoring-monitor-setup`

"You are a monitoring and observability expert specializing in implementing comprehensive monitoring solutions. Set up metrics collection, distributed tracing, log aggregation, and create insightful da"

*Source:* `/Users/elliesmith/.cursor/skills/skills/observability-monitoring-monitor-setup/SKILL.md`

## `observability-monitoring-slo-implement`

**In chat:** `/observability-monitoring-slo-implement`

"You are an SLO (Service Level Objective) expert specializing in implementing reliability standards and error budget-based practices. Design SLO frameworks, define SLIs, and build monitoring that balances reliability with delivery velocity."

*Source:* `/Users/elliesmith/.cursor/skills/skills/observability-monitoring-slo-implement/SKILL.md`

## `observe-whatsapp`

**In chat:** `/observe-whatsapp`

"Observe and troubleshoot WhatsApp in Kapso: debug message delivery, inspect webhook deliveries/retries, triage API errors, and run health checks. Use when investigating production issues, message failures, or webhook delivery problems."

*Source:* `/Users/elliesmith/.cursor/skills/skills/observe-whatsapp/SKILL.md`

## `obsidian-clipper-template-creator`

**In chat:** `/obsidian-clipper-template-creator`

Guide for creating templates for the Obsidian Web Clipper. Use when you want to create a new clipping template, understand available variables, or format clipped content.

*Source:* `/Users/elliesmith/.cursor/skills/skills/obsidian-clipper-template-creator/SKILL.md`

## `on-call-handoff-patterns`

**In chat:** `/on-call-handoff-patterns`

Master on-call shift handoffs with context transfer, escalation procedures, and documentation. Use when transitioning on-call responsibilities, documenting shift summaries, or improving on-call processes.

*Source:* `/Users/elliesmith/.cursor/skills/skills/on-call-handoff-patterns/SKILL.md`

## `onboarding-cro`

**In chat:** `/onboarding-cro`

When the user wants to optimize post-signup onboarding, user activation, first-run experience, or time-to-value. Also use when the user mentions "onboarding flow," "activation rate," "user activation," "first-run experience," "empty states," "onboarding checklist," "aha moment," or "new user experience." For signup/registration optimization, see signup-flow-cro. For ongoing email sequences, see email-sequence.

*Source:* `/Users/elliesmith/.cursor/skills/skills/onboarding-cro/SKILL.md`

## `one-drive-automation`

**In chat:** `/one-drive-automation`

"Automate OneDrive file management, search, uploads, downloads, sharing, permissions, and folder operations via Rube MCP (Composio). Always search tools first for current schemas."

*Source:* `/Users/elliesmith/.cursor/skills/skills/one-drive-automation/SKILL.md`

## `openai-docs`

**In chat:** `/openai-docs`

"Use when the user asks how to build with OpenAI products or APIs and needs up-to-date official documentation with citations, help choosing the latest model for a use case, or explicit GPT-5.4 upgrade and prompt-upgrade guidance; prioritize OpenAI docs MCP tools, use bundled references only as helper context, and restrict any fallback browsing to official OpenAI domains."

*Source:* `/Users/elliesmith/.codex/skills/.system/openai-docs/SKILL.md`

## `openapi-spec-generation`

**In chat:** `/openapi-spec-generation`

Generate and maintain OpenAPI 3.1 specifications from code, design-first specs, and validation patterns. Use when creating API documentation, generating SDKs, or ensuring API contract compliance.

*Source:* `/Users/elliesmith/.cursor/skills/skills/openapi-spec-generation/SKILL.md`

## `oss-hunter`

**In chat:** `/oss-hunter`

Automatically hunt for high-impact OSS contribution opportunities in trending repositories.

*Source:* `/Users/elliesmith/.cursor/skills/skills/oss-hunter/SKILL.md`

## `outlook-automation`

**In chat:** `/outlook-automation`

"Automate Outlook tasks via Rube MCP (Composio): emails, calendar, contacts, folders, attachments. Always search tools first for current schemas."

*Source:* `/Users/elliesmith/.cursor/skills/skills/outlook-automation/SKILL.md`

## `outlook-calendar-automation`

**In chat:** `/outlook-calendar-automation`

"Automate Outlook Calendar tasks via Rube MCP (Composio): create events, manage attendees, find meeting times, and handle invitations. Always search tools first for current schemas."

*Source:* `/Users/elliesmith/.cursor/skills/skills/outlook-calendar-automation/SKILL.md`

## `page-cro`

**In chat:** `/page-cro`

Analyze and optimize individual pages for conversion performance. Use when the user wants to improve conversion rates, diagnose why a page is underperforming, or increase the effectiveness of marketing pages (homepage, landing pages, pricing, feature pages, or blog posts). This skill focuses on diagnosis, prioritization, and testable recommendations— not blind optimization.

*Source:* `/Users/elliesmith/.cursor/skills/skills/page-cro/SKILL.md`

## `pagerduty-automation`

**In chat:** `/pagerduty-automation`

"Automate PagerDuty tasks via Rube MCP (Composio): manage incidents, services, schedules, escalation policies, and on-call rotations. Always search tools first for current schemas."

*Source:* `/Users/elliesmith/.cursor/skills/skills/pagerduty-automation/SKILL.md`

## `paid-ads`

**In chat:** `/paid-ads`

"When the user wants help with paid advertising campaigns on Google Ads, Meta (Facebook/Instagram), LinkedIn, Twitter/X, or other ad platforms. Also use when the user mentions 'PPC,' 'paid media,' 'ad copy,' 'ad creative,' 'ROAS,' 'CPA,' 'ad campaign,' 'retargeting,' or 'audience targeting.' This skill covers campaign strategy, ad creation, audience targeting, and optimization."

*Source:* `/Users/elliesmith/.cursor/skills/skills/paid-ads/SKILL.md`

## `parallel-agents`

**In chat:** `/parallel-agents`

Multi-agent orchestration patterns. Use when multiple independent tasks can run with different domain expertise or when comprehensive analysis requires multiple perspectives.

*Source:* `/Users/elliesmith/.cursor/skills/skills/parallel-agents/SKILL.md`

## `payment-integration`

**In chat:** `/payment-integration`

Integrate Stripe, PayPal, and payment processors. Handles checkout flows, subscriptions, webhooks, and PCI compliance. Use PROACTIVELY when implementing payments, billing, or subscription features.

*Source:* `/Users/elliesmith/.cursor/skills/skills/payment-integration/SKILL.md`

## `paypal-integration`

**In chat:** `/paypal-integration`

Integrate PayPal payment processing with support for express checkout, subscriptions, and refund management. Use when implementing PayPal payments, processing online transactions, or building e-commerce checkout flows.

*Source:* `/Users/elliesmith/.cursor/skills/skills/paypal-integration/SKILL.md`

## `paywall-upgrade-cro`

**In chat:** `/paywall-upgrade-cro`

When the user wants to create or optimize in-app paywalls, upgrade screens, upsell modals, or feature gates. Also use when the user mentions "paywall," "upgrade screen," "upgrade modal," "upsell," "feature gate," "convert free to paid," "freemium conversion," "trial expiration screen," "limit reached screen," "plan upgrade prompt," or "in-app pricing." Distinct from public pricing pages (see page-cro) — this skill focuses on in-product upgrade moments where the user has already experienced value.

*Source:* `/Users/elliesmith/.cursor/skills/skills/paywall-upgrade-cro/SKILL.md`

## `pc-games`

**In chat:** `/pc-games`

PC and console game development principles. Engine selection, platform features, optimization strategies.

*Source:* `/Users/elliesmith/.cursor/skills/skills/game-development/pc-games/SKILL.md`

## `pci-compliance`

**In chat:** `/pci-compliance`

Implement PCI DSS compliance requirements for secure handling of payment card data and payment systems. Use when securing payment processing, achieving PCI compliance, or implementing payment card security measures.

*Source:* `/Users/elliesmith/.cursor/skills/skills/pci-compliance/SKILL.md`

## `pdf`

**In chat:** `/pdf-official`

Comprehensive PDF manipulation toolkit for extracting text and tables, creating new PDFs, merging/splitting documents, and handling forms. When Claude needs to fill in a PDF form or programmatically process, generate, or analyze PDF documents at scale.

*Source:* `/Users/elliesmith/.cursor/skills/skills/pdf-official/SKILL.md`

## `Pentest Checklist`

**In chat:** `/pentest-checklist`

This skill should be used when the user asks to "plan a penetration test", "create a security assessment checklist", "prepare for penetration testing", "define pentest scope", "follow security testing best practices", or needs a structured methodology for penetration testing engagements.

*Source:* `/Users/elliesmith/.cursor/skills/skills/pentest-checklist/SKILL.md`

## `Pentest Commands`

**In chat:** `/pentest-commands`

This skill should be used when the user asks to "run pentest commands", "scan with nmap", "use metasploit exploits", "crack passwords with hydra or john", "scan web vulnerabilities with nikto", "enumerate networks", or needs essential penetration testing command references.

*Source:* `/Users/elliesmith/.cursor/skills/skills/pentest-commands/SKILL.md`

## `performance-engineer`

**In chat:** `/performance-engineer`

Expert performance engineer specializing in modern observability, application optimization, and scalable system performance. Masters OpenTelemetry, distributed tracing, load testing, multi-tier caching, Core Web Vitals, and performance monitoring. Handles end-to-end optimization, real user monitoring, and scalability patterns. Use PROACTIVELY for performance optimization, observability, or scalability challenges.

*Source:* `/Users/elliesmith/.cursor/skills/skills/performance-engineer/SKILL.md`

## `performance-profiling`

**In chat:** `/performance-profiling`

Performance profiling principles. Measurement, analysis, and optimization techniques.

*Source:* `/Users/elliesmith/.cursor/skills/skills/performance-profiling/SKILL.md`

## `performance-testing-review-ai-review`

**In chat:** `/performance-testing-review-ai-review`

"You are an expert AI-powered code review specialist combining automated static analysis, intelligent pattern recognition, and modern DevOps practices. Leverage AI tools (GitHub Copilot, Qodo, GPT-5, C"

*Source:* `/Users/elliesmith/.cursor/skills/skills/performance-testing-review-ai-review/SKILL.md`

## `performance-testing-review-multi-agent-review`

**In chat:** `/performance-testing-review-multi-agent-review`

"Use when working with performance testing review multi agent review"

*Source:* `/Users/elliesmith/.cursor/skills/skills/performance-testing-review-multi-agent-review/SKILL.md`

## `personal-tool-builder`

**In chat:** `/personal-tool-builder`

"Expert in building custom tools that solve your own problems first. The best products often start as personal tools - scratch your own itch, build for yourself, then discover others have the same itch. Covers rapid prototyping, local-first apps, CLI tools, scripts that grow into products, and the art of dogfooding. Use when: build a tool, personal tool, scratch my itch, solve my problem, CLI tool."

*Source:* `/Users/elliesmith/.cursor/skills/skills/personal-tool-builder/SKILL.md`

## `php-pro`

**In chat:** `/php-pro`

Write idiomatic PHP code with generators, iterators, SPL data structures, and modern OOP features. Use PROACTIVELY for high-performance PHP applications.

*Source:* `/Users/elliesmith/.cursor/skills/skills/php-pro/SKILL.md`

## `pipedrive-automation`

**In chat:** `/pipedrive-automation`

"Automate Pipedrive CRM operations including deals, contacts, organizations, activities, notes, and pipeline management via Rube MCP (Composio). Always search tools first for current schemas."

*Source:* `/Users/elliesmith/.cursor/skills/skills/pipedrive-automation/SKILL.md`

## `plaid-fintech`

**In chat:** `/plaid-fintech`

"Expert patterns for Plaid API integration including Link token flows, transactions sync, identity verification, Auth for ACH, balance checks, webhook handling, and fintech compliance best practices. Use when: plaid, bank account linking, bank connection, ach, account aggregation."

*Source:* `/Users/elliesmith/.cursor/skills/skills/plaid-fintech/SKILL.md`

## `plan-writing`

**In chat:** `/plan-writing`

Structured task planning with clear breakdowns, dependencies, and verification criteria. Use when implementing features, refactoring, or any multi-step work.

*Source:* `/Users/elliesmith/.cursor/skills/skills/plan-writing/SKILL.md`

## `planning-with-files`

**In chat:** `/planning-with-files`

Implements Manus-style file-based planning for complex tasks. Creates task_plan.md, findings.md, and progress.md. Use when starting complex multi-step tasks, research projects, or any task requiring >5 tool calls.

*Source:* `/Users/elliesmith/.cursor/skills/skills/planning-with-files/SKILL.md`

## `playwright-skill`

**In chat:** `/playwright-skill`

Complete browser automation with Playwright. Auto-detects dev servers, writes clean test scripts to /tmp. Test pages, fill forms, take screenshots, check responsive design, validate UX, test login flows, check links, automate any browser task. Use when user wants to test websites, automate browser interactions, validate web functionality, or perform any browser-based testing.

*Source:* `/Users/elliesmith/.cursor/skills/skills/playwright-skill/SKILL.md`

## `plugin-creator`

**In chat:** `/plugin-creator`

Create and scaffold plugin directories for Codex with a required `.codex-plugin/plugin.json`, optional plugin folders/files, and baseline placeholders you can edit before publishing or testing. Use when Codex needs to create a new local plugin, add optional plugin structure, or generate or update repo-root `.agents/plugins/marketplace.json` entries for plugin ordering and availability metadata.

*Source:* `/Users/elliesmith/.codex/skills/.system/plugin-creator/SKILL.md`

## `podcast-generation`

**In chat:** `/podcast-generation`

Generate AI-powered podcast-style audio narratives using Azure OpenAI's GPT Realtime Mini model via WebSocket. Use when building text-to-speech features, audio narrative generation, podcast creation from content, or integrating with Azure OpenAI Realtime API for real audio output. Covers full-stack implementation from React frontend to Python FastAPI backend with WebSocket streaming.

*Source:* `/Users/elliesmith/.cursor/skills/skills/podcast-generation/SKILL.md`

## `popup-cro`

**In chat:** `/popup-cro`

Create and optimize popups, modals, overlays, slide-ins, and banners to increase conversions without harming user experience or brand trust.

*Source:* `/Users/elliesmith/.cursor/skills/skills/popup-cro/SKILL.md`

## `posix-shell-pro`

**In chat:** `/posix-shell-pro`

Expert in strict POSIX sh scripting for maximum portability across Unix-like systems. Specializes in shell scripts that run on any POSIX-compliant shell (dash, ash, sh, bash --posix).

*Source:* `/Users/elliesmith/.cursor/skills/skills/posix-shell-pro/SKILL.md`

## `postgresql`

**In chat:** `/postgresql`

Design a PostgreSQL-specific schema. Covers best-practices, data types, indexing, constraints, performance patterns, and advanced features

*Source:* `/Users/elliesmith/.cursor/skills/skills/postgresql/SKILL.md`

## `posthog-automation`

**In chat:** `/posthog-automation`

"Automate PostHog tasks via Rube MCP (Composio): events, feature flags, projects, user profiles, annotations. Always search tools first for current schemas."

*Source:* `/Users/elliesmith/.cursor/skills/skills/posthog-automation/SKILL.md`

## `postmark-automation`

**In chat:** `/postmark-automation`

"Automate Postmark email delivery tasks via Rube MCP (Composio): send templated emails, manage templates, monitor delivery stats and bounces. Always search tools first for current schemas."

*Source:* `/Users/elliesmith/.cursor/skills/skills/postmark-automation/SKILL.md`

## `postmortem-writing`

**In chat:** `/postmortem-writing`

Write effective blameless postmortems with root cause analysis, timelines, and action items. Use when conducting incident reviews, writing postmortem documents, or improving incident response processes.

*Source:* `/Users/elliesmith/.cursor/skills/skills/postmortem-writing/SKILL.md`

## `powershell-windows`

**In chat:** `/powershell-windows`

PowerShell Windows patterns. Critical pitfalls, operator syntax, error handling.

*Source:* `/Users/elliesmith/.cursor/skills/skills/powershell-windows/SKILL.md`

## `pptx`

**In chat:** `/pptx-official`

"Presentation creation, editing, and analysis. When Claude needs to work with presentations (.pptx files) for: (1) Creating new presentations, (2) Modifying or editing content, (3) Working with layouts, (4) Adding comments or speaker notes, or any other presentation tasks"

*Source:* `/Users/elliesmith/.cursor/skills/skills/pptx-official/SKILL.md`

## `pricing-strategy`

**In chat:** `/pricing-strategy`

Design pricing, packaging, and monetization strategies based on value, customer willingness to pay, and growth objectives.

*Source:* `/Users/elliesmith/.cursor/skills/skills/pricing-strategy/SKILL.md`

## `prisma-expert`

**In chat:** `/prisma-expert`

Prisma ORM expert for schema design, migrations, query optimization, relations modeling, and database operations. Use PROACTIVELY for Prisma schema issues, migration problems, query performance, relation design, or database connection issues.

*Source:* `/Users/elliesmith/.cursor/skills/skills/prisma-expert/SKILL.md`

## `Privilege Escalation Methods`

**In chat:** `/privilege-escalation-methods`

This skill should be used when the user asks to "escalate privileges", "get root access", "become administrator", "privesc techniques", "abuse sudo", "exploit SUID binaries", "Kerberoasting", "pass-the-ticket", "token impersonation", or needs guidance on post-exploitation privilege escalation for Linux or Windows systems.

*Source:* `/Users/elliesmith/.cursor/skills/skills/privilege-escalation-methods/SKILL.md`

## `product-manager-toolkit`

**In chat:** `/product-manager-toolkit`

Comprehensive toolkit for product managers including RICE prioritization, customer interview analysis, PRD templates, discovery frameworks, and go-to-market strategies. Use for feature prioritization, user research synthesis, requirement documentation, and product strategy development.

*Source:* `/Users/elliesmith/.cursor/skills/skills/product-manager-toolkit/SKILL.md`

## `production-code-audit`

**In chat:** `/production-code-audit`

"Autonomously deep-scan entire codebase line-by-line, understand architecture and patterns, then systematically transform it to production-grade, corporate-level professional quality with optimizations"

*Source:* `/Users/elliesmith/.cursor/skills/skills/production-code-audit/SKILL.md`

## `programmatic-seo`

**In chat:** `/programmatic-seo`

Design and evaluate programmatic SEO strategies for creating SEO-driven pages at scale using templates and structured data. Use when the user mentions programmatic SEO, pages at scale, template pages, directory pages, location pages, comparison pages, integration pages, or keyword-pattern page generation. This skill focuses on feasibility, strategy, and page system design—not execution unless explicitly requested.

*Source:* `/Users/elliesmith/.cursor/skills/skills/programmatic-seo/SKILL.md`

## `projection-patterns`

**In chat:** `/projection-patterns`

Build read models and projections from event streams. Use when implementing CQRS read sides, building materialized views, or optimizing query performance in event-sourced systems.

*Source:* `/Users/elliesmith/.cursor/skills/skills/projection-patterns/SKILL.md`

## `prometheus-configuration`

**In chat:** `/prometheus-configuration`

Set up Prometheus for comprehensive metric collection, storage, and monitoring of infrastructure and applications. Use when implementing metrics collection, setting up monitoring infrastructure, or configuring alerting systems.

*Source:* `/Users/elliesmith/.cursor/skills/skills/prometheus-configuration/SKILL.md`

## `prompt-caching`

**In chat:** `/prompt-caching`

"Caching strategies for LLM prompts including Anthropic prompt caching, response caching, and CAG (Cache Augmented Generation) Use when: prompt caching, cache prompt, response cache, cag, cache augmented."

*Source:* `/Users/elliesmith/.cursor/skills/skills/prompt-caching/SKILL.md`

## `prompt-engineer`

**In chat:** `/prompt-engineer`

"Transforms user prompts into optimized prompts using frameworks (RTF, RISEN, Chain of Thought, RODES, Chain of Density, RACE, RISE, STAR, SOAP, CLEAR, GROW)"

*Source:* `/Users/elliesmith/.cursor/skills/skills/prompt-engineer/SKILL.md`

## `prompt-engineering`

**In chat:** `/prompt-engineering`

Expert guide on prompt engineering patterns, best practices, and optimization techniques. Use when user wants to improve prompts, learn prompting strategies, or debug agent behavior.

*Source:* `/Users/elliesmith/.cursor/skills/skills/prompt-engineering/SKILL.md`

## `prompt-engineering-patterns`

**In chat:** `/prompt-engineering-patterns`

Master advanced prompt engineering techniques to maximize LLM performance, reliability, and controllability in production. Use when optimizing prompts, improving LLM outputs, or designing production prompt templates.

*Source:* `/Users/elliesmith/.cursor/skills/skills/prompt-engineering-patterns/SKILL.md`

## `prompt-library`

**In chat:** `/prompt-library`

"Curated collection of high-quality prompts for various use cases. Includes role-based prompts, task-specific templates, and prompt refinement techniques. Use when user needs prompt templates, role-play prompts, or ready-to-use prompt examples for coding, writing, analysis, or creative tasks."

*Source:* `/Users/elliesmith/.cursor/skills/skills/prompt-library/SKILL.md`

## `protocol-reverse-engineering`

**In chat:** `/protocol-reverse-engineering`

Master network protocol reverse engineering including packet analysis, protocol dissection, and custom protocol documentation. Use when analyzing network traffic, understanding proprietary protocols, or debugging network communication.

*Source:* `/Users/elliesmith/.cursor/skills/skills/protocol-reverse-engineering/SKILL.md`

## `pydantic-models-py`

**In chat:** `/pydantic-models-py`

Create Pydantic models following the multi-model pattern with Base, Create, Update, Response, and InDB variants. Use when defining API request/response schemas, database models, or data validation in Python applications using Pydantic v2.

*Source:* `/Users/elliesmith/.cursor/skills/skills/pydantic-models-py/SKILL.md`

## `pypict-skill`

**In chat:** `/pypict-skill`

"Pairwise test generation"

*Source:* `/Users/elliesmith/.cursor/skills/skills/pypict-skill/SKILL.md`

## `python-development-python-scaffold`

**In chat:** `/python-development-python-scaffold`

"You are a Python project architecture expert specializing in scaffolding production-ready Python applications. Generate complete project structures with modern tooling (uv, FastAPI, Django), type hint"

*Source:* `/Users/elliesmith/.cursor/skills/skills/python-development-python-scaffold/SKILL.md`

## `python-packaging`

**In chat:** `/python-packaging`

Create distributable Python packages with proper project structure, setup.py/pyproject.toml, and publishing to PyPI. Use when packaging Python libraries, creating CLI tools, or distributing Python code.

*Source:* `/Users/elliesmith/.cursor/skills/skills/python-packaging/SKILL.md`

## `python-patterns`

**In chat:** `/python-patterns`

Python development principles and decision-making. Framework selection, async patterns, type hints, project structure. Teaches thinking, not copying.

*Source:* `/Users/elliesmith/.cursor/skills/skills/python-patterns/SKILL.md`

## `python-performance-optimization`

**In chat:** `/python-performance-optimization`

Profile and optimize Python code using cProfile, memory profilers, and performance best practices. Use when debugging slow Python code, optimizing bottlenecks, or improving application performance.

*Source:* `/Users/elliesmith/.cursor/skills/skills/python-performance-optimization/SKILL.md`

## `python-pro`

**In chat:** `/python-pro`

Master Python 3.12+ with modern features, async programming, performance optimization, and production-ready practices. Expert in the latest Python ecosystem including uv, ruff, pydantic, and FastAPI. Use PROACTIVELY for Python development, optimization, or advanced Python patterns.

*Source:* `/Users/elliesmith/.cursor/skills/skills/python-pro/SKILL.md`

## `python-testing-patterns`

**In chat:** `/python-testing-patterns`

Implement comprehensive testing strategies with pytest, fixtures, mocking, and test-driven development. Use when writing Python tests, setting up test suites, or implementing testing best practices.

*Source:* `/Users/elliesmith/.cursor/skills/skills/python-testing-patterns/SKILL.md`

## `quant-analyst`

**In chat:** `/quant-analyst`

Build financial models, backtest trading strategies, and analyze market data. Implements risk metrics, portfolio optimization, and statistical arbitrage. Use PROACTIVELY for quantitative finance, trading algorithms, or risk analysis.

*Source:* `/Users/elliesmith/.cursor/skills/skills/quant-analyst/SKILL.md`

## `radix-ui-design-system`

**In chat:** `/radix-ui-design-system`

Build accessible design systems with Radix UI primitives. Headless component customization, theming strategies, and compound component patterns for production-grade UI libraries.

*Source:* `/Users/elliesmith/.cursor/skills/skills/radix-ui-design-system/SKILL.md`

## `rag-engineer`

**In chat:** `/rag-engineer`

"Expert in building Retrieval-Augmented Generation systems. Masters embedding models, vector databases, chunking strategies, and retrieval optimization for LLM applications. Use when: building RAG, vector search, embeddings, semantic search, document retrieval."

*Source:* `/Users/elliesmith/.cursor/skills/skills/rag-engineer/SKILL.md`

## `rag-implementation`

**In chat:** `/rag-implementation`

Build Retrieval-Augmented Generation (RAG) systems for LLM applications with vector databases and semantic search. Use when implementing knowledge-grounded AI, building document Q&A systems, or integrating LLMs with external knowledge bases.

*Source:* `/Users/elliesmith/.cursor/skills/skills/rag-implementation/SKILL.md`

## `react-flow-architect`

**In chat:** `/react-flow-architect`

"Expert ReactFlow architect for building interactive graph applications with hierarchical node-edge systems, performance optimization, and auto-layout integration. Use when Claude needs to create or optimize ReactFlow applications for: (1) Interactive process graphs with expand/collapse navigation, (2) Hierarchical tree structures with drag & drop, (3) Performance-optimized large datasets with incremental rendering, (4) Auto-layout integration with Dagre, (5) Complex state management for nodes and edges, or any advanced ReactFlow visualization requirements."

*Source:* `/Users/elliesmith/.cursor/skills/skills/react-flow-architect/SKILL.md`

## `react-flow-node-ts`

**In chat:** `/react-flow-node-ts`

Create React Flow node components with TypeScript types, handles, and Zustand integration. Use when building custom nodes for React Flow canvas, creating visual workflow editors, or implementing node-based UI components.

*Source:* `/Users/elliesmith/.cursor/skills/skills/react-flow-node-ts/SKILL.md`

## `react-modernization`

**In chat:** `/react-modernization`

Upgrade React applications to latest versions, migrate from class components to hooks, and adopt concurrent features. Use when modernizing React codebases, migrating to React Hooks, or upgrading to latest React versions.

*Source:* `/Users/elliesmith/.cursor/skills/skills/react-modernization/SKILL.md`

## `react-native-architecture`

**In chat:** `/react-native-architecture`

Build production React Native apps with Expo, navigation, native modules, offline sync, and cross-platform patterns. Use when developing mobile apps, implementing native integrations, or architecting React Native projects.

*Source:* `/Users/elliesmith/.cursor/skills/skills/react-native-architecture/SKILL.md`

## `react-patterns`

**In chat:** `/react-patterns`

Modern React patterns and principles. Hooks, composition, performance, TypeScript best practices.

*Source:* `/Users/elliesmith/.cursor/skills/skills/react-patterns/SKILL.md`

## `react-state-management`

**In chat:** `/react-state-management`

Master modern React state management with Redux Toolkit, Zustand, Jotai, and React Query. Use when setting up global state, managing server state, or choosing between state management solutions.

*Source:* `/Users/elliesmith/.cursor/skills/skills/react-state-management/SKILL.md`

## `react-ui-patterns`

**In chat:** `/react-ui-patterns`

Modern React UI patterns for loading states, error handling, and data fetching. Use when building UI components, handling async data, or managing UI states.

*Source:* `/Users/elliesmith/.cursor/skills/skills/react-ui-patterns/SKILL.md`

## `readme`

**In chat:** `/readme`

"When the user wants to create or update a README.md file for a project. Also use when the user says 'write readme,' 'create readme,' 'document this project,' 'project documentation,' or asks for help with README.md. This skill creates absurdly thorough documentation covering local setup, architecture, and deployment."

*Source:* `/Users/elliesmith/.cursor/skills/skills/readme/SKILL.md`

## `receiving-code-review`

**In chat:** `/receiving-code-review`

Use when receiving code review feedback, before implementing suggestions, especially if feedback seems unclear or technically questionable - requires technical rigor and verification, not performative agreement or blind implementation

*Source:* `/Users/elliesmith/.cursor/skills/skills/receiving-code-review/SKILL.md`

## `Red Team Tools and Methodology`

**In chat:** `/red-team-tools`

This skill should be used when the user asks to "follow red team methodology", "perform bug bounty hunting", "automate reconnaissance", "hunt for XSS vulnerabilities", "enumerate subdomains", or needs security researcher techniques and tool configurations from top bug bounty hunters.

*Source:* `/Users/elliesmith/.cursor/skills/skills/red-team-tools/SKILL.md`

## `red-team-tactics`

**In chat:** `/red-team-tactics`

Red team tactics principles based on MITRE ATT&CK. Attack phases, detection evasion, reporting.

*Source:* `/Users/elliesmith/.cursor/skills/skills/red-team-tactics/SKILL.md`

## `reddit-automation`

**In chat:** `/reddit-automation`

"Automate Reddit tasks via Rube MCP (Composio): search subreddits, create posts, manage comments, and browse top content. Always search tools first for current schemas."

*Source:* `/Users/elliesmith/.cursor/skills/skills/reddit-automation/SKILL.md`

## `reference-builder`

**In chat:** `/reference-builder`

Creates exhaustive technical references and API documentation. Generates comprehensive parameter listings, configuration guides, and searchable reference materials. Use PROACTIVELY for API docs, configuration references, or complete technical specifications.

*Source:* `/Users/elliesmith/.cursor/skills/skills/reference-builder/SKILL.md`

## `referral-program`

**In chat:** `/referral-program`

"When the user wants to create, optimize, or analyze a referral program, affiliate program, or word-of-mouth strategy. Also use when the user mentions 'referral,' 'affiliate,' 'ambassador,' 'word of mouth,' 'viral loop,' 'refer a friend,' or 'partner program.' This skill covers program design, incentive structure, and growth optimization."

*Source:* `/Users/elliesmith/.cursor/skills/skills/referral-program/SKILL.md`

## `remotion-best-practices`

**In chat:** `/remotion-best-practices`

Best practices for Remotion - Video creation in React

*Source:* `/Users/elliesmith/.cursor/skills/skills/remotion-best-practices/SKILL.md`

## `render-automation`

**In chat:** `/render-automation`

"Automate Render tasks via Rube MCP (Composio): services, deployments, projects. Always search tools first for current schemas."

*Source:* `/Users/elliesmith/.cursor/skills/skills/render-automation/SKILL.md`

## `requesting-code-review`

**In chat:** `/requesting-code-review`

Use when completing tasks, implementing major features, or before merging to verify work meets requirements

*Source:* `/Users/elliesmith/.cursor/skills/skills/requesting-code-review/SKILL.md`

## `research-engineer`

**In chat:** `/research-engineer`

"An uncompromising Academic Research Engineer. Operates with absolute scientific rigor, objective criticism, and zero flair. Focuses on theoretical correctness, formal verification, and optimal implementation across any required technology."

*Source:* `/Users/elliesmith/.cursor/skills/skills/research-engineer/SKILL.md`

## `reverse-engineer`

**In chat:** `/reverse-engineer`

Expert reverse engineer specializing in binary analysis, disassembly, decompilation, and software analysis. Masters IDA Pro, Ghidra, radare2, x64dbg, and modern RE toolchains. Handles executable analysis, library inspection, protocol extraction, and vulnerability research. Use PROACTIVELY for binary analysis, CTF challenges, security research, or understanding undocumented software.

*Source:* `/Users/elliesmith/.cursor/skills/skills/reverse-engineer/SKILL.md`

## `risk-manager`

**In chat:** `/risk-manager`

Monitor portfolio risk, R-multiples, and position limits. Creates hedging strategies, calculates expectancy, and implements stop-losses. Use PROACTIVELY for risk assessment, trade tracking, or portfolio protection.

*Source:* `/Users/elliesmith/.cursor/skills/skills/risk-manager/SKILL.md`

## `risk-metrics-calculation`

**In chat:** `/risk-metrics-calculation`

Calculate portfolio risk metrics including VaR, CVaR, Sharpe, Sortino, and drawdown analysis. Use when measuring portfolio risk, implementing risk limits, or building risk monitoring systems.

*Source:* `/Users/elliesmith/.cursor/skills/skills/risk-metrics-calculation/SKILL.md`

## `ruby-pro`

**In chat:** `/ruby-pro`

Write idiomatic Ruby code with metaprogramming, Rails patterns, and performance optimization. Specializes in Ruby on Rails, gem development, and testing frameworks. Use PROACTIVELY for Ruby refactoring, optimization, or complex Ruby features.

*Source:* `/Users/elliesmith/.cursor/skills/skills/ruby-pro/SKILL.md`

## `rust-async-patterns`

**In chat:** `/rust-async-patterns`

Master Rust async programming with Tokio, async traits, error handling, and concurrent patterns. Use when building async Rust applications, implementing concurrent systems, or debugging async code.

*Source:* `/Users/elliesmith/.cursor/skills/skills/rust-async-patterns/SKILL.md`

## `rust-pro`

**In chat:** `/rust-pro`

Master Rust 1.75+ with modern async patterns, advanced type system features, and production-ready systems programming. Expert in the latest Rust ecosystem including Tokio, axum, and cutting-edge crates. Use PROACTIVELY for Rust development, performance optimization, or systems programming.

*Source:* `/Users/elliesmith/.cursor/skills/skills/rust-pro/SKILL.md`

## `saga-orchestration`

**In chat:** `/saga-orchestration`

Implement saga patterns for distributed transactions and cross-aggregate workflows. Use when coordinating multi-step business processes, handling compensating transactions, or managing long-running workflows.

*Source:* `/Users/elliesmith/.cursor/skills/skills/saga-orchestration/SKILL.md`

## `sales-automator`

**In chat:** `/sales-automator`

Draft cold emails, follow-ups, and proposal templates. Creates pricing pages, case studies, and sales scripts. Use PROACTIVELY for sales outreach or lead nurturing.

*Source:* `/Users/elliesmith/.cursor/skills/skills/sales-automator/SKILL.md`

## `salesforce-automation`

**In chat:** `/salesforce-automation`

"Automate Salesforce tasks via Rube MCP (Composio): leads, contacts, accounts, opportunities, SOQL queries. Always search tools first for current schemas."

*Source:* `/Users/elliesmith/.cursor/skills/skills/salesforce-automation/SKILL.md`

## `salesforce-development`

**In chat:** `/salesforce-development`

"Expert patterns for Salesforce platform development including Lightning Web Components (LWC), Apex triggers and classes, REST/Bulk APIs, Connected Apps, and Salesforce DX with scratch orgs and 2nd generation packages (2GP). Use when: salesforce, sfdc, apex, lwc, lightning web components."

*Source:* `/Users/elliesmith/.cursor/skills/skills/salesforce-development/SKILL.md`

## `sast-configuration`

**In chat:** `/sast-configuration`

Configure Static Application Security Testing (SAST) tools for automated vulnerability detection in application code. Use when setting up security scanning, implementing DevSecOps practices, or automating code vulnerability detection.

*Source:* `/Users/elliesmith/.cursor/skills/skills/sast-configuration/SKILL.md`

## `scala-pro`

**In chat:** `/scala-pro`

Master enterprise-grade Scala development with functional programming, distributed systems, and big data processing. Expert in Apache Pekko, Akka, Spark, ZIO/Cats Effect, and reactive architectures. Use PROACTIVELY for Scala system design, performance optimization, or enterprise integration.

*Source:* `/Users/elliesmith/.cursor/skills/skills/scala-pro/SKILL.md`

## `schema-markup`

**In chat:** `/schema-markup`

Design, validate, and optimize schema.org structured data for eligibility, correctness, and measurable SEO impact. Use when the user wants to add, fix, audit, or scale schema markup (JSON-LD) for rich results. This skill evaluates whether schema should be implemented, what types are valid, and how to deploy safely according to Google guidelines.

*Source:* `/Users/elliesmith/.cursor/skills/skills/schema-markup/SKILL.md`

## `screen-reader-testing`

**In chat:** `/screen-reader-testing`

Test web applications with screen readers including VoiceOver, NVDA, and JAWS. Use when validating screen reader compatibility, debugging accessibility issues, or ensuring assistive technology support.

*Source:* `/Users/elliesmith/.cursor/skills/skills/screen-reader-testing/SKILL.md`

## `screenshots`

**In chat:** `/screenshots`

"Generate marketing screenshots of your app using Playwright. Use when the user wants to create screenshots for Product Hunt, social media, landing pages, or documentation."

*Source:* `/Users/elliesmith/.cursor/skills/skills/screenshots/SKILL.md`

## `scroll-experience`

**In chat:** `/scroll-experience`

"Expert in building immersive scroll-driven experiences - parallax storytelling, scroll animations, interactive narratives, and cinematic web experiences. Like NY Times interactives, Apple product pages, and award-winning web experiences. Makes websites feel like experiences, not just pages. Use when: scroll animation, parallax, scroll storytelling, interactive story, cinematic website."

*Source:* `/Users/elliesmith/.cursor/skills/skills/scroll-experience/SKILL.md`

## `search-specialist`

**In chat:** `/search-specialist`

Expert web researcher using advanced search techniques and synthesis. Masters search operators, result filtering, and multi-source verification. Handles competitive analysis and fact-checking. Use PROACTIVELY for deep research, information gathering, or trend analysis.

*Source:* `/Users/elliesmith/.cursor/skills/skills/search-specialist/SKILL.md`

## `secrets-management`

**In chat:** `/secrets-management`

Implement secure secrets management for CI/CD pipelines using Vault, AWS Secrets Manager, or native platform solutions. Use when handling sensitive credentials, rotating secrets, or securing CI/CD environments.

*Source:* `/Users/elliesmith/.cursor/skills/skills/secrets-management/SKILL.md`

## `Security Scanning Tools`

**In chat:** `/scanning-tools`

This skill should be used when the user asks to "perform vulnerability scanning", "scan networks for open ports", "assess web application security", "scan wireless networks", "detect malware", "check cloud security", or "evaluate system compliance". It provides comprehensive guidance on security scanning tools and methodologies.

*Source:* `/Users/elliesmith/.cursor/skills/skills/scanning-tools/SKILL.md`

## `security-auditor`

**In chat:** `/security-auditor`

Expert security auditor specializing in DevSecOps, comprehensive cybersecurity, and compliance frameworks. Masters vulnerability assessment, threat modeling, secure authentication (OAuth2/OIDC), OWASP standards, cloud security, and security automation. Handles DevSecOps integration, compliance (GDPR/HIPAA/SOC2), and incident response. Use PROACTIVELY for security audits, DevSecOps, or compliance implementation.

*Source:* `/Users/elliesmith/.cursor/skills/skills/security-auditor/SKILL.md`

## `security-bluebook-builder`

**In chat:** `/security-bluebook-builder`

"Build security Blue Books for sensitive apps"

*Source:* `/Users/elliesmith/.cursor/skills/skills/security-bluebook-builder/SKILL.md`

## `security-compliance-compliance-check`

**In chat:** `/security-compliance-compliance-check`

"You are a compliance expert specializing in regulatory requirements for software systems including GDPR, HIPAA, SOC2, PCI-DSS, and other industry standards. Perform compliance audits and provide implementation guidance."

*Source:* `/Users/elliesmith/.cursor/skills/skills/security-compliance-compliance-check/SKILL.md`

## `security-requirement-extraction`

**In chat:** `/security-requirement-extraction`

Derive security requirements from threat models and business context. Use when translating threats into actionable requirements, creating security user stories, or building security test cases.

*Source:* `/Users/elliesmith/.cursor/skills/skills/security-requirement-extraction/SKILL.md`

## `security-review`

**In chat:** `/cc-skill-security-review`

Use this skill when adding authentication, handling user input, working with secrets, creating API endpoints, or implementing payment/sensitive features. Provides comprehensive security checklist and patterns.

*Source:* `/Users/elliesmith/.cursor/skills/skills/cc-skill-security-review/SKILL.md`

## `security-scanning-security-dependencies`

**In chat:** `/security-scanning-security-dependencies`

"You are a security expert specializing in dependency vulnerability analysis, SBOM generation, and supply chain security. Scan project dependencies across ecosystems to identify vulnerabilities, assess risks, and recommend remediation."

*Source:* `/Users/elliesmith/.cursor/skills/skills/security-scanning-security-dependencies/SKILL.md`

## `security-scanning-security-hardening`

**In chat:** `/security-scanning-security-hardening`

"Coordinate multi-layer security scanning and hardening across application, infrastructure, and compliance controls."

*Source:* `/Users/elliesmith/.cursor/skills/skills/security-scanning-security-hardening/SKILL.md`

## `security-scanning-security-sast`

**In chat:** `/security-scanning-security-sast`

Static Application Security Testing (SAST) for code vulnerability analysis across multiple languages and frameworks

*Source:* `/Users/elliesmith/.cursor/skills/skills/security-scanning-security-sast/SKILL.md`

## `segment-automation`

**In chat:** `/segment-automation`

"Automate Segment tasks via Rube MCP (Composio): track events, identify users, manage groups, page views, aliases, batch operations. Always search tools first for current schemas."

*Source:* `/Users/elliesmith/.cursor/skills/skills/segment-automation/SKILL.md`

## `segment-cdp`

**In chat:** `/segment-cdp`

"Expert patterns for Segment Customer Data Platform including Analytics.js, server-side tracking, tracking plans with Protocols, identity resolution, destinations configuration, and data governance best practices. Use when: segment, analytics.js, customer data platform, cdp, tracking plan."

*Source:* `/Users/elliesmith/.cursor/skills/skills/segment-cdp/SKILL.md`

## `sendgrid-automation`

**In chat:** `/sendgrid-automation`

"Automate SendGrid email operations including sending emails, managing contacts/lists, sender identities, templates, and analytics via Rube MCP (Composio). Always search tools first for current schemas."

*Source:* `/Users/elliesmith/.cursor/skills/skills/sendgrid-automation/SKILL.md`

## `senior-architect`

**In chat:** `/senior-architect`

Comprehensive software architecture skill for designing scalable, maintainable systems using ReactJS, NextJS, NodeJS, Express, React Native, Swift, Kotlin, Flutter, Postgres, GraphQL, Go, Python. Includes architecture diagram generation, system design patterns, tech stack decision frameworks, and dependency analysis. Use when designing system architecture, making technical decisions, creating architecture diagrams, evaluating trade-offs, or defining integration patterns.

*Source:* `/Users/elliesmith/.cursor/skills/skills/senior-architect/SKILL.md`

## `senior-fullstack`

**In chat:** `/senior-fullstack`

Comprehensive fullstack development skill for building complete web applications with React, Next.js, Node.js, GraphQL, and PostgreSQL. Includes project scaffolding, code quality analysis, architecture patterns, and complete tech stack guidance. Use when building new projects, analyzing code quality, implementing design patterns, or setting up development workflows.

*Source:* `/Users/elliesmith/.cursor/skills/skills/senior-fullstack/SKILL.md`

## `sentry-automation`

**In chat:** `/sentry-automation`

"Automate Sentry tasks via Rube MCP (Composio): manage issues/events, configure alerts, track releases, monitor projects and teams. Always search tools first for current schemas."

*Source:* `/Users/elliesmith/.cursor/skills/skills/sentry-automation/SKILL.md`

## `seo-audit`

**In chat:** `/seo-audit`

Diagnose and audit SEO issues affecting crawlability, indexation, rankings, and organic performance. Use when the user asks for an SEO audit, technical SEO review, ranking diagnosis, on-page SEO review, meta tag audit, or SEO health check. This skill identifies issues and prioritizes actions but does not execute changes. For large-scale page creation, use programmatic-seo. For structured data, use schema-markup.

*Source:* `/Users/elliesmith/.cursor/skills/skills/seo-audit/SKILL.md`

## `seo-authority-builder`

**In chat:** `/seo-authority-builder`

Analyzes content for E-E-A-T signals and suggests improvements to build authority and trust. Identifies missing credibility elements. Use PROACTIVELY for YMYL topics.

*Source:* `/Users/elliesmith/.cursor/skills/skills/seo-authority-builder/SKILL.md`

## `seo-cannibalization-detector`

**In chat:** `/seo-cannibalization-detector`

Analyzes multiple provided pages to identify keyword overlap and potential cannibalization issues. Suggests differentiation strategies. Use PROACTIVELY when reviewing similar content.

*Source:* `/Users/elliesmith/.cursor/skills/skills/seo-cannibalization-detector/SKILL.md`

## `seo-content-auditor`

**In chat:** `/seo-content-auditor`

Analyzes provided content for quality, E-E-A-T signals, and SEO best practices. Scores content and provides improvement recommendations based on established guidelines. Use PROACTIVELY for content review.

*Source:* `/Users/elliesmith/.cursor/skills/skills/seo-content-auditor/SKILL.md`

## `seo-content-planner`

**In chat:** `/seo-content-planner`

Creates comprehensive content outlines and topic clusters for SEO. Plans content calendars and identifies topic gaps. Use PROACTIVELY for content strategy and planning.

*Source:* `/Users/elliesmith/.cursor/skills/skills/seo-content-planner/SKILL.md`

## `seo-content-refresher`

**In chat:** `/seo-content-refresher`

Identifies outdated elements in provided content and suggests updates to maintain freshness. Finds statistics, dates, and examples that need updating. Use PROACTIVELY for older content.

*Source:* `/Users/elliesmith/.cursor/skills/skills/seo-content-refresher/SKILL.md`

## `seo-content-writer`

**In chat:** `/seo-content-writer`

Writes SEO-optimized content based on provided keywords and topic briefs. Creates engaging, comprehensive content following best practices. Use PROACTIVELY for content creation tasks.

*Source:* `/Users/elliesmith/.cursor/skills/skills/seo-content-writer/SKILL.md`

## `seo-fundamentals`

**In chat:** `/seo-fundamentals`

Core principles of SEO including E-E-A-T, Core Web Vitals, technical foundations, content quality, and how modern search engines evaluate pages. This skill explains *why* SEO works, not how to execute specific optimizations.

*Source:* `/Users/elliesmith/.cursor/skills/skills/seo-fundamentals/SKILL.md`

## `seo-keyword-strategist`

**In chat:** `/seo-keyword-strategist`

Analyzes keyword usage in provided content, calculates density, suggests semantic variations and LSI keywords based on the topic. Prevents over-optimization. Use PROACTIVELY for content optimization.

*Source:* `/Users/elliesmith/.cursor/skills/skills/seo-keyword-strategist/SKILL.md`

## `seo-meta-optimizer`

**In chat:** `/seo-meta-optimizer`

Creates optimized meta titles, descriptions, and URL suggestions based on character limits and best practices. Generates compelling, keyword-rich metadata. Use PROACTIVELY for new content.

*Source:* `/Users/elliesmith/.cursor/skills/skills/seo-meta-optimizer/SKILL.md`

## `seo-snippet-hunter`

**In chat:** `/seo-snippet-hunter`

Formats content to be eligible for featured snippets and SERP features. Creates snippet-optimized content blocks based on best practices. Use PROACTIVELY for question-based content.

*Source:* `/Users/elliesmith/.cursor/skills/skills/seo-snippet-hunter/SKILL.md`

## `seo-structure-architect`

**In chat:** `/seo-structure-architect`

Analyzes and optimizes content structure including header hierarchy, suggests schema markup, and internal linking opportunities. Creates search-friendly content organization. Use PROACTIVELY for content structuring.

*Source:* `/Users/elliesmith/.cursor/skills/skills/seo-structure-architect/SKILL.md`

## `server-management`

**In chat:** `/server-management`

Server management principles and decision-making. Process management, monitoring strategy, and scaling decisions. Teaches thinking, not commands.

*Source:* `/Users/elliesmith/.cursor/skills/skills/server-management/SKILL.md`

## `service-mesh-expert`

**In chat:** `/service-mesh-expert`

"Expert service mesh architect specializing in Istio, Linkerd, and cloud-native networking patterns. Masters traffic management, security policies, observability integration, and multi-cluster mesh con"

*Source:* `/Users/elliesmith/.cursor/skills/skills/service-mesh-expert/SKILL.md`

## `service-mesh-observability`

**In chat:** `/service-mesh-observability`

Implement comprehensive observability for service meshes including distributed tracing, metrics, and visualization. Use when setting up mesh monitoring, debugging latency issues, or implementing SLOs for service communication.

*Source:* `/Users/elliesmith/.cursor/skills/skills/service-mesh-observability/SKILL.md`

## `sharp-edges`

**In chat:** `/sharp-edges`

"Identify error-prone APIs and dangerous configurations"

*Source:* `/Users/elliesmith/.cursor/skills/skills/sharp-edges/SKILL.md`

## `shell`

**In chat:** `/shell`

Runs the rest of a /shell request as a literal shell command. Use only when the user explicitly invokes /shell and wants the following text executed directly in the terminal.

*Source:* `/Users/elliesmith/.cursor/skills-cursor/shell/SKILL.md`

## `shellcheck-configuration`

**In chat:** `/shellcheck-configuration`

Master ShellCheck static analysis configuration and usage for shell script quality. Use when setting up linting infrastructure, fixing code issues, or ensuring script portability.

*Source:* `/Users/elliesmith/.cursor/skills/skills/shellcheck-configuration/SKILL.md`

## `Shodan Reconnaissance and Pentesting`

**In chat:** `/shodan-reconnaissance`

This skill should be used when the user asks to "search for exposed devices on the internet," "perform Shodan reconnaissance," "find vulnerable services using Shodan," "scan IP ranges with Shodan," or "discover IoT devices and open ports." It provides comprehensive guidance for using Shodan's search engine, CLI, and API for penetration testing reconnaissance.

*Source:* `/Users/elliesmith/.cursor/skills/skills/shodan-reconnaissance/SKILL.md`

## `shopify-apps`

**In chat:** `/shopify-apps`

"Expert patterns for Shopify app development including Remix/React Router apps, embedded apps with App Bridge, webhook handling, GraphQL Admin API, Polaris components, billing, and app extensions. Use when: shopify app, shopify, embedded app, polaris, app bridge."

*Source:* `/Users/elliesmith/.cursor/skills/skills/shopify-apps/SKILL.md`

## `shopify-automation`

**In chat:** `/shopify-automation`

"Automate Shopify tasks via Rube MCP (Composio): products, orders, customers, inventory, collections. Always search tools first for current schemas."

*Source:* `/Users/elliesmith/.cursor/skills/skills/shopify-automation/SKILL.md`

## `shopify-development`

**In chat:** `/shopify-development`

Build Shopify apps, extensions, themes using GraphQL Admin API, Shopify CLI, Polaris UI, and Liquid. TRIGGER: "shopify", "shopify app", "checkout extension", "admin extension", "POS extension", "shopify theme", "liquid template", "polaris", "shopify graphql", "shopify webhook", "shopify billing", "app subscription", "metafields", "shopify functions"

*Source:* `/Users/elliesmith/.cursor/skills/skills/shopify-development/SKILL.md`

## `signup-flow-cro`

**In chat:** `/signup-flow-cro`

When the user wants to optimize signup, registration, account creation, or trial activation flows. Also use when the user mentions "signup conversions," "registration friction," "signup form optimization," "free trial signup," "reduce signup dropoff," or "account creation flow." For post-signup onboarding, see onboarding-cro. For lead capture forms (not account creation), see form-cro.

*Source:* `/Users/elliesmith/.cursor/skills/skills/signup-flow-cro/SKILL.md`

## `similarity-search-patterns`

**In chat:** `/similarity-search-patterns`

Implement efficient similarity search with vector databases. Use when building semantic search, implementing nearest neighbor queries, or optimizing retrieval performance.

*Source:* `/Users/elliesmith/.cursor/skills/skills/similarity-search-patterns/SKILL.md`

## `skill-creator`

**In chat:** `/skill-creator-ms`

Guide for creating effective skills for AI coding agents working with Azure SDKs and Microsoft Foundry services. Use when creating new skills or updating existing skills.

*Source:* `/Users/elliesmith/.cursor/skills/skills/skill-creator-ms/SKILL.md`

## `skill-developer`

**In chat:** `/skill-developer`

Create and manage Claude Code skills following Anthropic best practices. Use when creating new skills, modifying skill-rules.json, understanding trigger patterns, working with hooks, debugging skill activation, or implementing progressive disclosure. Covers skill structure, YAML frontmatter, trigger types (keywords, intent patterns, file paths, content patterns), enforcement levels (block, suggest, warn), hook mechanisms (UserPromptSubmit, PreToolUse), session tracking, and the 500-line rule.

*Source:* `/Users/elliesmith/.cursor/skills/skills/skill-developer/SKILL.md`

## `skill-installer`

**In chat:** `/skill-installer`

Install Codex skills into $CODEX_HOME/skills from a curated list or a GitHub repo path. Use when a user asks to list installable skills, install a curated skill, or install a skill from another repo (including private repos).

*Source:* `/Users/elliesmith/.codex/skills/.system/skill-installer/SKILL.md`

## `skill-rails-upgrade`

**In chat:** `/skill-rails-upgrade`

"Analyze Rails apps and provide upgrade assessments"

*Source:* `/Users/elliesmith/.cursor/skills/skills/skill-rails-upgrade/SKILL.md`

## `skill-seekers`

**In chat:** `/skill-seekers`

"-Automatically convert documentation websites, GitHub repositories, and PDFs into Claude AI skills in minutes."

*Source:* `/Users/elliesmith/.cursor/skills/skills/skill-seekers/SKILL.md`

## `slack-automation`

**In chat:** `/slack-automation`

"Automate Slack messaging, channel management, search, reactions, and threads via Rube MCP (Composio). Send messages, search conversations, manage channels/users, and react to messages programmatically."

*Source:* `/Users/elliesmith/.cursor/skills/skills/slack-automation/SKILL.md`

## `slack-bot-builder`

**In chat:** `/slack-bot-builder`

"Build Slack apps using the Bolt framework across Python, JavaScript, and Java. Covers Block Kit for rich UIs, interactive components, slash commands, event handling, OAuth installation flows, and Workflow Builder integration. Focus on best practices for production-ready Slack apps. Use when: slack bot, slack app, bolt framework, block kit, slash command."

*Source:* `/Users/elliesmith/.cursor/skills/skills/slack-bot-builder/SKILL.md`

## `slack-gif-creator`

**In chat:** `/slack-gif-creator`

Knowledge and utilities for creating animated GIFs optimized for Slack. Provides constraints, validation tools, and animation concepts. Use when users request animated GIFs for Slack like "make me a GIF of X doing Y for Slack."

*Source:* `/Users/elliesmith/.cursor/skills/skills/slack-gif-creator/SKILL.md`

## `slo-implementation`

**In chat:** `/slo-implementation`

Define and implement Service Level Indicators (SLIs) and Service Level Objectives (SLOs) with error budgets and alerting. Use when establishing reliability targets, implementing SRE practices, or measuring service performance.

*Source:* `/Users/elliesmith/.cursor/skills/skills/slo-implementation/SKILL.md`

## `SMTP Penetration Testing`

**In chat:** `/smtp-penetration-testing`

This skill should be used when the user asks to "perform SMTP penetration testing", "enumerate email users", "test for open mail relays", "grab SMTP banners", "brute force email credentials", or "assess mail server security". It provides comprehensive techniques for testing SMTP server security.

*Source:* `/Users/elliesmith/.cursor/skills/skills/smtp-penetration-testing/SKILL.md`

## `social-content`

**In chat:** `/social-content`

"When the user wants help creating, scheduling, or optimizing social media content for LinkedIn, Twitter/X, Instagram, TikTok, Facebook, or other platforms. Also use when the user mentions 'LinkedIn post,' 'Twitter thread,' 'social media,' 'content calendar,' 'social scheduling,' 'engagement,' or 'viral content.' This skill covers content creation, repurposing, and platform-specific strategies."

*Source:* `/Users/elliesmith/.cursor/skills/skills/social-content/SKILL.md`

## `software-architecture`

**In chat:** `/software-architecture`

Guide for quality focused software architecture. This skill should be used when users want to write code, design architecture, analyze code, in any case that relates to software development.

*Source:* `/Users/elliesmith/.cursor/skills/skills/software-architecture/SKILL.md`

## `solidity-security`

**In chat:** `/solidity-security`

Master smart contract security best practices to prevent common vulnerabilities and implement secure Solidity patterns. Use when writing smart contracts, auditing existing contracts, or implementing security measures for blockchain applications.

*Source:* `/Users/elliesmith/.cursor/skills/skills/solidity-security/SKILL.md`

## `spark-optimization`

**In chat:** `/spark-optimization`

Optimize Apache Spark jobs with partitioning, caching, shuffle optimization, and memory tuning. Use when improving Spark performance, debugging slow jobs, or scaling data processing pipelines.

*Source:* `/Users/elliesmith/.cursor/skills/skills/spark-optimization/SKILL.md`

## `SQL Injection Testing`

**In chat:** `/sql-injection-testing`

This skill should be used when the user asks to "test for SQL injection vulnerabilities", "perform SQLi attacks", "bypass authentication using SQL injection", "extract database information through injection", "detect SQL injection flaws", or "exploit database query vulnerabilities". It provides comprehensive techniques for identifying, exploiting, and understanding SQL injection attack vectors across different database systems.

*Source:* `/Users/elliesmith/.cursor/skills/skills/sql-injection-testing/SKILL.md`

## `sql-optimization-patterns`

**In chat:** `/sql-optimization-patterns`

Master SQL query optimization, indexing strategies, and EXPLAIN analysis to dramatically improve database performance and eliminate slow queries. Use when debugging slow queries, designing database schemas, or optimizing application performance.

*Source:* `/Users/elliesmith/.cursor/skills/skills/sql-optimization-patterns/SKILL.md`

## `sql-pro`

**In chat:** `/sql-pro`

Master modern SQL with cloud-native databases, OLTP/OLAP optimization, and advanced query techniques. Expert in performance tuning, data modeling, and hybrid analytical systems. Use PROACTIVELY for database optimization or complex analysis.

*Source:* `/Users/elliesmith/.cursor/skills/skills/sql-pro/SKILL.md`

## `SQLMap Database Penetration Testing`

**In chat:** `/sqlmap-database-pentesting`

This skill should be used when the user asks to "automate SQL injection testing," "enumerate database structure," "extract database credentials using sqlmap," "dump tables and columns from a vulnerable database," or "perform automated database penetration testing." It provides comprehensive guidance for using SQLMap to detect and exploit SQL injection vulnerabilities.

*Source:* `/Users/elliesmith/.cursor/skills/skills/sqlmap-database-pentesting/SKILL.md`

## `square-automation`

**In chat:** `/square-automation`

"Automate Square tasks via Rube MCP (Composio): payments, orders, invoices, locations. Always search tools first for current schemas."

*Source:* `/Users/elliesmith/.cursor/skills/skills/square-automation/SKILL.md`

## `SSH Penetration Testing`

**In chat:** `/ssh-penetration-testing`

This skill should be used when the user asks to "pentest SSH services", "enumerate SSH configurations", "brute force SSH credentials", "exploit SSH vulnerabilities", "perform SSH tunneling", or "audit SSH security". It provides comprehensive SSH penetration testing methodologies and techniques.

*Source:* `/Users/elliesmith/.cursor/skills/skills/ssh-penetration-testing/SKILL.md`

## `startup-analyst`

**In chat:** `/startup-analyst`

Expert startup business analyst specializing in market sizing, financial modeling, competitive analysis, and strategic planning for early-stage companies. Use PROACTIVELY when the user asks about market opportunity, TAM/SAM/SOM, financial projections, unit economics, competitive landscape, team planning, startup metrics, or business strategy for pre-seed through Series A startups.

*Source:* `/Users/elliesmith/.cursor/skills/skills/startup-analyst/SKILL.md`

## `startup-business-analyst-business-case`

**In chat:** `/startup-business-analyst-business-case`

Generate comprehensive investor-ready business case document with market, solution, financials, and strategy

*Source:* `/Users/elliesmith/.cursor/skills/skills/startup-business-analyst-business-case/SKILL.md`

## `startup-business-analyst-financial-projections`

**In chat:** `/startup-business-analyst-financial-projections`

Create detailed 3-5 year financial model with revenue, costs, cash flow, and scenarios

*Source:* `/Users/elliesmith/.cursor/skills/skills/startup-business-analyst-financial-projections/SKILL.md`

## `startup-business-analyst-market-opportunity`

**In chat:** `/startup-business-analyst-market-opportunity`

Generate comprehensive market opportunity analysis with TAM/SAM/SOM calculations

*Source:* `/Users/elliesmith/.cursor/skills/skills/startup-business-analyst-market-opportunity/SKILL.md`

## `startup-financial-modeling`

**In chat:** `/startup-financial-modeling`

This skill should be used when the user asks to "create financial projections", "build a financial model", "forecast revenue", "calculate burn rate", "estimate runway", "model cash flow", or requests 3-5 year financial planning for a startup.

*Source:* `/Users/elliesmith/.cursor/skills/skills/startup-financial-modeling/SKILL.md`

## `startup-metrics-framework`

**In chat:** `/startup-metrics-framework`

This skill should be used when the user asks about "key startup metrics", "SaaS metrics", "CAC and LTV", "unit economics", "burn multiple", "rule of 40", "marketplace metrics", or requests guidance on tracking and optimizing business performance metrics.

*Source:* `/Users/elliesmith/.cursor/skills/skills/startup-metrics-framework/SKILL.md`

## `statusline`

**In chat:** `/statusline`

Configure a custom status line in the CLI. Use when the user mentions status line, statusline, statusLine, CLI status bar, prompt footer customization, or wants to add session context above the prompt.

*Source:* `/Users/elliesmith/.cursor/skills-cursor/statusline/SKILL.md`

## `stitch-ui-design`

**In chat:** `/stitch-ui-design`

Expert guide for creating effective prompts for Google Stitch AI UI design tool. Use when user wants to design UI/UX in Stitch, create app interfaces, generate mobile/web designs, or needs help crafting Stitch prompts. Covers prompt structure, specificity techniques, iteration strategies, and design-to-code workflows for Stitch by Google.

*Source:* `/Users/elliesmith/.cursor/skills/skills/stitch-ui-design/SKILL.md`

## `stride-analysis-patterns`

**In chat:** `/stride-analysis-patterns`

Apply STRIDE methodology to systematically identify threats. Use when analyzing system security, conducting threat modeling sessions, or creating security documentation.

*Source:* `/Users/elliesmith/.cursor/skills/skills/stride-analysis-patterns/SKILL.md`

## `stripe-automation`

**In chat:** `/stripe-automation`

"Automate Stripe tasks via Rube MCP (Composio): customers, charges, subscriptions, invoices, products, refunds. Always search tools first for current schemas."

*Source:* `/Users/elliesmith/.cursor/skills/skills/stripe-automation/SKILL.md`

## `stripe-integration`

**In chat:** `/stripe-integration`

Implement Stripe payment processing for robust, PCI-compliant payment flows including checkout, subscriptions, and webhooks. Use when integrating Stripe payments, building subscription systems, or implementing secure checkout flows.

*Source:* `/Users/elliesmith/.cursor/skills/skills/stripe-integration/SKILL.md`

## `subagent-driven-development`

**In chat:** `/subagent-driven-development`

Use when executing implementation plans with independent tasks in the current session

*Source:* `/Users/elliesmith/.cursor/skills/skills/subagent-driven-development/SKILL.md`

## `supabase-automation`

**In chat:** `/supabase-automation`

"Automate Supabase database queries, table management, project administration, storage, edge functions, and SQL execution via Rube MCP (Composio). Always search tools first for current schemas."

*Source:* `/Users/elliesmith/.cursor/skills/skills/supabase-automation/SKILL.md`

## `supabase-postgres-best-practices`

**In chat:** `/postgres-best-practices`

Postgres performance optimization and best practices from Supabase. Use this skill when writing, reviewing, or optimizing Postgres queries, schema designs, or database configurations.

*Source:* `/Users/elliesmith/.cursor/skills/skills/postgres-best-practices/SKILL.md`

## `superpowers-lab`

**In chat:** `/superpowers-lab`

"Lab environment for Claude superpowers"

*Source:* `/Users/elliesmith/.cursor/skills/skills/superpowers-lab/SKILL.md`

## `swiftui-expert-skill`

**In chat:** `/swiftui-expert-skill`

"Write, review, or improve SwiftUI code following best practices for state management, view composition, performance, modern APIs, Swift concurrency, and iOS 26+ Liquid Glass adoption. Use when building new SwiftUI features, refactoring existing views, reviewing code quality, or adopting modern SwiftUI patterns."

*Source:* `/Users/elliesmith/.cursor/skills/skills/swiftui-expert-skill/SKILL.md`

## `systematic-debugging`

**In chat:** `/systematic-debugging`

Use when encountering any bug, test failure, or unexpected behavior, before proposing fixes

*Source:* `/Users/elliesmith/.cursor/skills/skills/systematic-debugging/SKILL.md`

## `systems-programming-rust-project`

**In chat:** `/systems-programming-rust-project`

"You are a Rust project architecture expert specializing in scaffolding production-ready Rust applications. Generate complete project structures with cargo tooling, proper module organization, testing"

*Source:* `/Users/elliesmith/.cursor/skills/skills/systems-programming-rust-project/SKILL.md`

## `tailwind-design-system`

**In chat:** `/tailwind-design-system`

Build scalable design systems with Tailwind CSS, design tokens, component libraries, and responsive patterns. Use when creating component libraries, implementing design systems, or standardizing UI patterns.

*Source:* `/Users/elliesmith/.cursor/skills/skills/tailwind-design-system/SKILL.md`

## `tailwind-patterns`

**In chat:** `/tailwind-patterns`

Tailwind CSS v4 principles. CSS-first configuration, container queries, modern patterns, design token architecture.

*Source:* `/Users/elliesmith/.cursor/skills/skills/tailwind-patterns/SKILL.md`

## `tavily-best-practices`

**In chat:** `/tavily-best-practices`

"Build production-ready Tavily integrations with best practices baked in. Reference documentation for developers using coding assistants (Claude Code, Cursor, etc.) to implement web search, content extraction, crawling, and research in agentic workflows, RAG systems, or autonomous agents."

*Source:* `/Users/elliesmith/.cursor/plugins/cache/cursor-public/tavily/b971db016d23a908fe7061fdeb213f9b6cb4d771/skills/tavily-best-practices/SKILL.md`

## `tavily-cli`

**In chat:** `/tavily-cli`

Web search, content extraction, crawling, and deep research via the Tavily CLI. Use this skill whenever the user wants to search the web, find articles, research a topic, look something up online, extract content from a URL, grab text from a webpage, crawl documentation, download a site's pages, discover URLs on a domain, or conduct in-depth research with citations. Also use when they say "fetch this page", "pull the content from", "get the page at https://", "find me articles about", or reference extracting data from external websites. This provides LLM-optimized web search, content extraction, site crawling, URL discovery, and AI-powered deep research — capabilities beyond what agents can do natively. Do NOT trigger for local file operations, git commands, deployments, or code editing tasks.

*Source:* `/Users/elliesmith/.cursor/plugins/cache/cursor-public/tavily/b971db016d23a908fe7061fdeb213f9b6cb4d771/skills/tavily-cli/SKILL.md`

## `tavily-crawl`

**In chat:** `/tavily-crawl`

Crawl websites and extract content from multiple pages via the Tavily CLI. Use this skill when the user wants to crawl a site, download documentation, extract an entire docs section, bulk-extract pages, save a site as local markdown files, or says "crawl", "get all the pages", "download the docs", "extract everything under /docs", "bulk extract", or needs content from many pages on the same domain. Supports depth/breadth control, path filtering, semantic instructions, and saving each page as a local markdown file.

*Source:* `/Users/elliesmith/.cursor/plugins/cache/cursor-public/tavily/b971db016d23a908fe7061fdeb213f9b6cb4d771/skills/tavily-crawl/SKILL.md`

## `tavily-extract`

**In chat:** `/tavily-extract`

Extract clean markdown or text content from specific URLs via the Tavily CLI. Use this skill when the user has one or more URLs and wants their content, says "extract", "grab the content from", "pull the text from", "get the page at", "read this webpage", or needs clean text from web pages. Handles JavaScript-rendered pages, returns LLM-optimized markdown, and supports query-focused chunking for targeted extraction. Can process up to 20 URLs in a single call.

*Source:* `/Users/elliesmith/.cursor/plugins/cache/cursor-public/tavily/b971db016d23a908fe7061fdeb213f9b6cb4d771/skills/tavily-extract/SKILL.md`

## `tavily-research`

**In chat:** `/tavily-research`

Conduct comprehensive AI-powered research with citations via the Tavily CLI. Use this skill when the user wants deep research, a detailed report, a comparison, market analysis, literature review, or says "research", "investigate", "analyze in depth", "compare X vs Y", "what does the market look like for", or needs multi-source synthesis with explicit citations. Returns a structured report grounded in web sources. Takes 30-120 seconds. For quick fact-finding, use tavily-search instead.

*Source:* `/Users/elliesmith/.cursor/plugins/cache/cursor-public/tavily/b971db016d23a908fe7061fdeb213f9b6cb4d771/skills/tavily-research/SKILL.md`

## `tavily-search`

**In chat:** `/tavily-search`

Search the web with LLM-optimized results via the Tavily CLI. Use this skill when the user wants to search the web, find articles, look up information, get recent news, discover sources, or says "search for", "find me", "look up", "what's the latest on", "find articles about", or needs current information from the internet. Returns relevant results with content snippets, relevance scores, and metadata — optimized for LLM consumption. Supports domain filtering, time ranges, and multiple search depths.

*Source:* `/Users/elliesmith/.cursor/plugins/cache/cursor-public/tavily/b971db016d23a908fe7061fdeb213f9b6cb4d771/skills/tavily-search/SKILL.md`

## `tavily-web`

**In chat:** `/tavily-web`

Web search, content extraction, crawling, and research capabilities using Tavily API

*Source:* `/Users/elliesmith/.cursor/skills/skills/tavily-web/SKILL.md`

## `tdd-orchestrator`

**In chat:** `/tdd-orchestrator`

Master TDD orchestrator specializing in red-green-refactor discipline, multi-agent workflow coordination, and comprehensive test-driven development practices. Enforces TDD best practices across teams with AI-assisted testing and modern frameworks. Use PROACTIVELY for TDD implementation and governance.

*Source:* `/Users/elliesmith/.cursor/skills/skills/tdd-orchestrator/SKILL.md`

## `tdd-workflow`

**In chat:** `/tdd-workflow`

Test-Driven Development workflow principles. RED-GREEN-REFACTOR cycle.

*Source:* `/Users/elliesmith/.cursor/skills/skills/tdd-workflow/SKILL.md`

## `tdd-workflows-tdd-cycle`

**In chat:** `/tdd-workflows-tdd-cycle`

"Use when working with tdd workflows tdd cycle"

*Source:* `/Users/elliesmith/.cursor/skills/skills/tdd-workflows-tdd-cycle/SKILL.md`

## `tdd-workflows-tdd-green`

**In chat:** `/tdd-workflows-tdd-green`

Implement the minimal code needed to make failing tests pass in the TDD green phase.

*Source:* `/Users/elliesmith/.cursor/skills/skills/tdd-workflows-tdd-green/SKILL.md`

## `tdd-workflows-tdd-red`

**In chat:** `/tdd-workflows-tdd-red`

Generate failing tests for the TDD red phase to define expected behavior and edge cases.

*Source:* `/Users/elliesmith/.cursor/skills/skills/tdd-workflows-tdd-red/SKILL.md`

## `tdd-workflows-tdd-refactor`

**In chat:** `/tdd-workflows-tdd-refactor`

"Use when working with tdd workflows tdd refactor"

*Source:* `/Users/elliesmith/.cursor/skills/skills/tdd-workflows-tdd-refactor/SKILL.md`

## `team-collaboration-issue`

**In chat:** `/team-collaboration-issue`

"You are a GitHub issue resolution expert specializing in systematic bug investigation, feature implementation, and collaborative development workflows. Your expertise spans issue triage, root cause an"

*Source:* `/Users/elliesmith/.cursor/skills/skills/team-collaboration-issue/SKILL.md`

## `team-collaboration-standup-notes`

**In chat:** `/team-collaboration-standup-notes`

"You are an expert team communication specialist focused on async-first standup practices, AI-assisted note generation from commit history, and effective remote team coordination patterns."

*Source:* `/Users/elliesmith/.cursor/skills/skills/team-collaboration-standup-notes/SKILL.md`

## `team-composition-analysis`

**In chat:** `/team-composition-analysis`

This skill should be used when the user asks to "plan team structure", "determine hiring needs", "design org chart", "calculate compensation", "plan equity allocation", or requests organizational design and headcount planning for a startup.

*Source:* `/Users/elliesmith/.cursor/skills/skills/team-composition-analysis/SKILL.md`

## `telegram-automation`

**In chat:** `/telegram-automation`

"Automate Telegram tasks via Rube MCP (Composio): send messages, manage chats, share photos/documents, and handle bot commands. Always search tools first for current schemas."

*Source:* `/Users/elliesmith/.cursor/skills/skills/telegram-automation/SKILL.md`

## `telegram-bot-builder`

**In chat:** `/telegram-bot-builder`

"Expert in building Telegram bots that solve real problems - from simple automation to complex AI-powered bots. Covers bot architecture, the Telegram Bot API, user experience, monetization strategies, and scaling bots to thousands of users. Use when: telegram bot, bot api, telegram automation, chat bot telegram, tg bot."

*Source:* `/Users/elliesmith/.cursor/skills/skills/telegram-bot-builder/SKILL.md`

## `telegram-mini-app`

**In chat:** `/telegram-mini-app`

"Expert in building Telegram Mini Apps (TWA) - web apps that run inside Telegram with native-like experience. Covers the TON ecosystem, Telegram Web App API, payments, user authentication, and building viral mini apps that monetize. Use when: telegram mini app, TWA, telegram web app, TON app, mini app."

*Source:* `/Users/elliesmith/.cursor/skills/skills/telegram-mini-app/SKILL.md`

## `templates`

**In chat:** `/templates`

Project scaffolding templates for new applications. Use when creating new projects from scratch. Contains 12 templates for various tech stacks.

*Source:* `/Users/elliesmith/.cursor/skills/skills/app-builder/templates/SKILL.md`

## `temporal-python-pro`

**In chat:** `/temporal-python-pro`

Master Temporal workflow orchestration with Python SDK. Implements durable workflows, saga patterns, and distributed transactions. Covers async/await, testing strategies, and production deployment. Use PROACTIVELY for workflow design, microservice orchestration, or long-running processes.

*Source:* `/Users/elliesmith/.cursor/skills/skills/temporal-python-pro/SKILL.md`

## `temporal-python-testing`

**In chat:** `/temporal-python-testing`

Test Temporal workflows with pytest, time-skipping, and mocking strategies. Covers unit testing, integration testing, replay testing, and local development setup. Use when implementing Temporal workflow tests or debugging test failures.

*Source:* `/Users/elliesmith/.cursor/skills/skills/temporal-python-testing/SKILL.md`

## `terraform-module-library`

**In chat:** `/terraform-module-library`

Build reusable Terraform modules for AWS, Azure, and GCP infrastructure following infrastructure-as-code best practices. Use when creating infrastructure modules, standardizing cloud provisioning, or implementing reusable IaC components.

*Source:* `/Users/elliesmith/.cursor/skills/skills/terraform-module-library/SKILL.md`

## `terraform-skill`

**In chat:** `/terraform-skill`

"Terraform infrastructure as code best practices"

*Source:* `/Users/elliesmith/.cursor/skills/skills/terraform-skill/SKILL.md`

## `terraform-specialist`

**In chat:** `/terraform-specialist`

Expert Terraform/OpenTofu specialist mastering advanced IaC automation, state management, and enterprise infrastructure patterns. Handles complex module design, multi-cloud deployments, GitOps workflows, policy as code, and CI/CD integration. Covers migration strategies, security best practices, and modern IaC ecosystems. Use PROACTIVELY for advanced IaC, state management, or infrastructure automation.

*Source:* `/Users/elliesmith/.cursor/skills/skills/terraform-specialist/SKILL.md`

## `test-automator`

**In chat:** `/test-automator`

Master AI-powered test automation with modern frameworks, self-healing tests, and comprehensive quality engineering. Build scalable testing strategies with advanced CI/CD integration. Use PROACTIVELY for testing automation or quality assurance.

*Source:* `/Users/elliesmith/.cursor/skills/skills/test-automator/SKILL.md`

## `test-driven-development`

**In chat:** `/test-driven-development`

Use when implementing any feature or bugfix, before writing implementation code

*Source:* `/Users/elliesmith/.cursor/skills/skills/test-driven-development/SKILL.md`

## `test-fixing`

**In chat:** `/test-fixing`

Run tests and systematically fix all failing tests using smart error grouping. Use when user asks to fix failing tests, mentions test failures, runs test suite and failures occur, or requests to make tests pass.

*Source:* `/Users/elliesmith/.cursor/skills/skills/test-fixing/SKILL.md`

## `testing-patterns`

**In chat:** `/testing-patterns`

Jest testing patterns, factory functions, mocking strategies, and TDD workflow. Use when writing unit tests, creating test factories, or following TDD red-green-refactor cycle.

*Source:* `/Users/elliesmith/.cursor/skills/skills/testing-patterns/SKILL.md`

## `theme-factory`

**In chat:** `/theme-factory`

Toolkit for styling artifacts with a theme. These artifacts can be slides, docs, reportings, HTML landing pages, etc. There are 10 pre-set themes with colors/fonts that you can apply to any artifact that has been creating, or can generate a new theme on-the-fly.

*Source:* `/Users/elliesmith/.cursor/skills/skills/theme-factory/SKILL.md`

## `threat-mitigation-mapping`

**In chat:** `/threat-mitigation-mapping`

Map identified threats to appropriate security controls and mitigations. Use when prioritizing security investments, creating remediation plans, or validating control effectiveness.

*Source:* `/Users/elliesmith/.cursor/skills/skills/threat-mitigation-mapping/SKILL.md`

## `threat-modeling-expert`

**In chat:** `/threat-modeling-expert`

"Expert in threat modeling methodologies, security architecture review, and risk assessment. Masters STRIDE, PASTA, attack trees, and security requirement extraction. Use for security architecture reviews, threat identification, and secure-by-design planning."

*Source:* `/Users/elliesmith/.cursor/skills/skills/threat-modeling-expert/SKILL.md`

## `threejs-skills`

**In chat:** `/threejs-skills`

Create 3D scenes, interactive experiences, and visual effects using Three.js. Use when user requests 3D graphics, WebGL experiences, 3D visualizations, animations, or interactive 3D elements.

*Source:* `/Users/elliesmith/.cursor/skills/skills/threejs-skills/SKILL.md`

## `tiktok-automation`

**In chat:** `/tiktok-automation`

"Automate TikTok tasks via Rube MCP (Composio): upload/publish videos, post photos, manage content, and view user profiles/stats. Always search tools first for current schemas."

*Source:* `/Users/elliesmith/.cursor/skills/skills/tiktok-automation/SKILL.md`

## `todoist-automation`

**In chat:** `/todoist-automation`

"Automate Todoist task management, projects, sections, filtering, and bulk operations via Rube MCP (Composio). Always search tools first for current schemas."

*Source:* `/Users/elliesmith/.cursor/skills/skills/todoist-automation/SKILL.md`

## `tool-design`

**In chat:** `/tool-design`

"Build tools that agents can use effectively, including architectural reduction patterns"

*Source:* `/Users/elliesmith/.cursor/skills/skills/tool-design/SKILL.md`

## `Top 100 Web Vulnerabilities Reference`

**In chat:** `/top-web-vulnerabilities`

This skill should be used when the user asks to "identify web application vulnerabilities", "explain common security flaws", "understand vulnerability categories", "learn about injection attacks", "review access control weaknesses", "analyze API security issues", "assess security misconfigurations", "understand client-side vulnerabilities", "examine mobile and IoT security flaws", or "reference the OWASP-aligned vulnerability taxonomy". Use this skill to provide comprehensive vulnerability definitions, root causes, impacts, and mitigation strategies across all major web security categories.

*Source:* `/Users/elliesmith/.cursor/skills/skills/top-web-vulnerabilities/SKILL.md`

## `track-management`

**In chat:** `/track-management`

Use this skill when creating, managing, or working with Conductor tracks - the logical work units for features, bugs, and refactors. Applies to spec.md, plan.md, and track lifecycle operations.

*Source:* `/Users/elliesmith/.cursor/skills/skills/track-management/SKILL.md`

## `trello-automation`

**In chat:** `/trello-automation`

"Automate Trello boards, cards, and workflows via Rube MCP (Composio). Create cards, manage lists, assign members, and search across boards programmatically."

*Source:* `/Users/elliesmith/.cursor/skills/skills/trello-automation/SKILL.md`

## `trigger-dev`

**In chat:** `/trigger-dev`

"Trigger.dev expert for background jobs, AI workflows, and reliable async execution with excellent developer experience and TypeScript-first design. Use when: trigger.dev, trigger dev, background task, ai background job, long running task."

*Source:* `/Users/elliesmith/.cursor/skills/skills/trigger-dev/SKILL.md`

## `turborepo-caching`

**In chat:** `/turborepo-caching`

Configure Turborepo for efficient monorepo builds with local and remote caching. Use when setting up Turborepo, optimizing build pipelines, or implementing distributed caching.

*Source:* `/Users/elliesmith/.cursor/skills/skills/turborepo-caching/SKILL.md`

## `tutorial-engineer`

**In chat:** `/tutorial-engineer`

Creates step-by-step tutorials and educational content from code. Transforms complex concepts into progressive learning experiences with hands-on examples. Use PROACTIVELY for onboarding guides, feature tutorials, or concept explanations.

*Source:* `/Users/elliesmith/.cursor/skills/skills/tutorial-engineer/SKILL.md`

## `twilio-communications`

**In chat:** `/twilio-communications`

"Build communication features with Twilio: SMS messaging, voice calls, WhatsApp Business API, and user verification (2FA). Covers the full spectrum from simple notifications to complex IVR systems and multi-channel authentication. Critical focus on compliance, rate limits, and error handling. Use when: twilio, send SMS, text message, voice call, phone verification."

*Source:* `/Users/elliesmith/.cursor/skills/skills/twilio-communications/SKILL.md`

## `twitter-automation`

**In chat:** `/twitter-automation`

"Automate Twitter/X tasks via Rube MCP (Composio): posts, search, users, bookmarks, lists, media. Always search tools first for current schemas."

*Source:* `/Users/elliesmith/.cursor/skills/skills/twitter-automation/SKILL.md`

## `typescript-advanced-types`

**In chat:** `/typescript-advanced-types`

Master TypeScript's advanced type system including generics, conditional types, mapped types, template literals, and utility types for building type-safe applications. Use when implementing complex type logic, creating reusable type utilities, or ensuring compile-time type safety in TypeScript projects.

*Source:* `/Users/elliesmith/.cursor/skills/skills/typescript-advanced-types/SKILL.md`

## `typescript-expert`

**In chat:** `/typescript-expert`

TypeScript and JavaScript expert with deep knowledge of type-level programming, performance optimization, monorepo management, migration strategies, and modern tooling. Use PROACTIVELY for any TypeScript/JavaScript issues including complex type gymnastics, build performance, debugging, and architectural decisions. If a specialized expert is a better fit, I will recommend switching and stop.

*Source:* `/Users/elliesmith/.cursor/skills/skills/typescript-expert/SKILL.md`

## `typescript-pro`

**In chat:** `/typescript-pro`

Master TypeScript with advanced types, generics, and strict type safety. Handles complex type systems, decorators, and enterprise-grade patterns. Use PROACTIVELY for TypeScript architecture, type inference optimization, or advanced typing patterns.

*Source:* `/Users/elliesmith/.cursor/skills/skills/typescript-pro/SKILL.md`

## `ui-skills`

**In chat:** `/ui-skills`

"Opinionated, evolving constraints to guide agents when building interfaces"

*Source:* `/Users/elliesmith/.cursor/skills/skills/ui-skills/SKILL.md`

## `ui-ux-designer`

**In chat:** `/ui-ux-designer`

Create interface designs, wireframes, and design systems. Masters user research, accessibility standards, and modern design tools. Specializes in design tokens, component libraries, and inclusive design. Use PROACTIVELY for design systems, user flows, or interface optimization.

*Source:* `/Users/elliesmith/.cursor/skills/skills/ui-ux-designer/SKILL.md`

## `ui-ux-pro-max`

**In chat:** `/ui-ux-pro-max`

"UI/UX design intelligence. 50 styles, 21 palettes, 50 font pairings, 20 charts, 9 stacks (React, Next.js, Vue, Svelte, SwiftUI, React Native, Flutter, Tailwind, shadcn/ui). Actions: plan, build, create, design, implement, review, fix, improve, optimize, enhance, refactor, check UI/UX code. Projects: website, landing page, dashboard, admin panel, e-commerce, SaaS, portfolio, blog, mobile app, .html, .tsx, .vue, .svelte. Elements: button, modal, navbar, sidebar, card, table, form, chart. Styles: glassmorphism, claymorphism, minimalism, brutalism, neumorphism, bento grid, dark mode, responsive, skeuomorphism, flat design. Topics: color palette, accessibility, animation, layout, typography, font pairing, spacing, hover, shadow, gradient. Integrations: shadcn/ui MCP for component search and examples."

*Source:* `/Users/elliesmith/.cursor/skills/skills/ui-ux-pro-max/SKILL.md`

## `ui-visual-validator`

**In chat:** `/ui-visual-validator`

Rigorous visual validation expert specializing in UI testing, design system compliance, and accessibility verification. Masters screenshot analysis, visual regression testing, and component validation. Use PROACTIVELY to verify UI modifications have achieved their intended goals through comprehensive visual analysis.

*Source:* `/Users/elliesmith/.cursor/skills/skills/ui-visual-validator/SKILL.md`

## `unit-testing-test-generate`

**In chat:** `/unit-testing-test-generate`

Generate comprehensive, maintainable unit tests across languages with strong coverage and edge case focus.

*Source:* `/Users/elliesmith/.cursor/skills/skills/unit-testing-test-generate/SKILL.md`

## `unity-developer`

**In chat:** `/unity-developer`

Build Unity games with optimized C# scripts, efficient rendering, and proper asset management. Masters Unity 6 LTS, URP/HDRP pipelines, and cross-platform deployment. Handles gameplay systems, UI implementation, and platform optimization. Use PROACTIVELY for Unity performance issues, game mechanics, or cross-platform builds.

*Source:* `/Users/elliesmith/.cursor/skills/skills/unity-developer/SKILL.md`

## `unity-ecs-patterns`

**In chat:** `/unity-ecs-patterns`

Master Unity ECS (Entity Component System) with DOTS, Jobs, and Burst for high-performance game development. Use when building data-oriented games, optimizing performance, or working with large entity counts.

*Source:* `/Users/elliesmith/.cursor/skills/skills/unity-ecs-patterns/SKILL.md`

## `unreal-engine-cpp-pro`

**In chat:** `/unreal-engine-cpp-pro`

Expert guide for Unreal Engine 5.x C++ development, covering UObject hygiene, performance patterns, and best practices.

*Source:* `/Users/elliesmith/.cursor/skills/skills/unreal-engine-cpp-pro/SKILL.md`

## `update-cli-config`

**In chat:** `/update-cli-config`

View and modify Cursor CLI configuration settings in cli-config.json. Use when the user wants to change CLI settings, configure permissions, switch approval mode, enable vim mode, toggle display options, configure sandbox, or manage any CLI preferences.

*Source:* `/Users/elliesmith/.cursor/skills-cursor/update-cli-config/SKILL.md`

## `update-cursor-settings`

**In chat:** `/update-cursor-settings`

Modify Cursor/VSCode user settings in settings.json. Use when you want to change editor settings, preferences, configuration, themes, font size, tab size, format on save, auto save, keybindings, or any settings.json values.

*Source:* `/Users/elliesmith/.cursor/skills-cursor/update-cursor-settings/SKILL.md`

## `upgrading-expo`

**In chat:** `/upgrading-expo`

"Upgrade Expo SDK versions"

*Source:* `/Users/elliesmith/.cursor/skills/skills/upgrading-expo/SKILL.md`

## `upstash-qstash`

**In chat:** `/upstash-qstash`

"Upstash QStash expert for serverless message queues, scheduled jobs, and reliable HTTP-based task delivery without managing infrastructure. Use when: qstash, upstash queue, serverless cron, scheduled http, message queue serverless."

*Source:* `/Users/elliesmith/.cursor/skills/skills/upstash-qstash/SKILL.md`

## `using-git-worktrees`

**In chat:** `/using-git-worktrees`

Use when starting feature work that needs isolation from current workspace or before executing implementation plans - creates isolated git worktrees with smart directory selection and safety verification

*Source:* `/Users/elliesmith/.cursor/skills/skills/using-git-worktrees/SKILL.md`

## `using-neon`

**In chat:** `/using-neon`

"Guides and best practices for working with Neon Serverless Postgres. Covers getting started, local development with Neon, choosing a connection method, Neon features, authentication (@neondatabase/auth), PostgREST-style data API (@neondatabase/neon-js), Neon CLI, and Neon's Platform API/SDKs. Use for any Neon-related questions."

*Source:* `/Users/elliesmith/.cursor/skills/skills/using-neon/SKILL.md`

## `using-superpowers`

**In chat:** `/using-superpowers`

Use when starting any conversation - establishes how to find and use skills, requiring Skill tool invocation before ANY response including clarifying questions

*Source:* `/Users/elliesmith/.cursor/skills/skills/using-superpowers/SKILL.md`

## `uv-package-manager`

**In chat:** `/uv-package-manager`

Master the uv package manager for fast Python dependency management, virtual environments, and modern Python project workflows. Use when setting up Python projects, managing dependencies, or optimizing Python development workflows with uv.

*Source:* `/Users/elliesmith/.cursor/skills/skills/uv-package-manager/SKILL.md`

## `varlock-claude-skill`

**In chat:** `/varlock-claude-skill`

"Secure environment variable management ensuring secrets are never exposed in Claude sessions, terminals, logs, or git commits"

*Source:* `/Users/elliesmith/.cursor/skills/skills/varlock-claude-skill/SKILL.md`

## `vector-database-engineer`

**In chat:** `/vector-database-engineer`

"Expert in vector databases, embedding strategies, and semantic search implementation. Masters Pinecone, Weaviate, Qdrant, Milvus, and pgvector for RAG applications, recommendation systems, and similar"

*Source:* `/Users/elliesmith/.cursor/skills/skills/vector-database-engineer/SKILL.md`

## `vector-index-tuning`

**In chat:** `/vector-index-tuning`

Optimize vector index performance for latency, recall, and memory. Use when tuning HNSW parameters, selecting quantization strategies, or scaling vector search infrastructure.

*Source:* `/Users/elliesmith/.cursor/skills/skills/vector-index-tuning/SKILL.md`

## `vercel-automation`

**In chat:** `/vercel-automation`

"Automate Vercel tasks via Rube MCP (Composio): manage deployments, domains, DNS, env vars, projects, and teams. Always search tools first for current schemas."

*Source:* `/Users/elliesmith/.cursor/skills/skills/vercel-automation/SKILL.md`

## `vercel-deploy-claimable`

**In chat:** `/vercel-deploy-claimable`

"Deploy applications and websites to Vercel. Use this skill when the user requests deployment actions such as 'Deploy my app', 'Deploy this to production', 'Create a preview deployment', 'Deploy and give me the link', or 'Push this live'. No authentication required - returns preview URL and claimable deployment link."

*Source:* `/Users/elliesmith/.cursor/skills/skills/vercel-deploy-claimable/SKILL.md`

## `vercel-deployment`

**In chat:** `/vercel-deployment`

"Expert knowledge for deploying to Vercel with Next.js Use when: vercel, deploy, deployment, hosting, production."

*Source:* `/Users/elliesmith/.cursor/skills/skills/vercel-deployment/SKILL.md`

## `vercel-react-best-practices`

**In chat:** `/react-best-practices`

React and Next.js performance optimization guidelines from Vercel Engineering. This skill should be used when writing, reviewing, or refactoring React/Next.js code to ensure optimal performance patterns. Triggers on tasks involving React components, Next.js pages, data fetching, bundle optimization, or performance improvements.

*Source:* `/Users/elliesmith/.cursor/skills/skills/react-best-practices/SKILL.md`

## `verification-before-completion`

**In chat:** `/verification-before-completion`

Use when about to claim work is complete, fixed, or passing, before committing or creating PRs - requires running verification commands and confirming output before making any success claims; evidence before assertions always

*Source:* `/Users/elliesmith/.cursor/skills/skills/verification-before-completion/SKILL.md`

## `vexor`

**In chat:** `/vexor`

"Vector-powered CLI for semantic file search with a Claude/Codex skill"

*Source:* `/Users/elliesmith/.cursor/skills/skills/vexor/SKILL.md`

## `viral-generator-builder`

**In chat:** `/viral-generator-builder`

"Expert in building shareable generator tools that go viral - name generators, quiz makers, avatar creators, personality tests, and calculator tools. Covers the psychology of sharing, viral mechanics, and building tools people can't resist sharing with friends. Use when: generator tool, quiz maker, name generator, avatar creator, viral tool."

*Source:* `/Users/elliesmith/.cursor/skills/skills/viral-generator-builder/SKILL.md`

## `visual-frontend-audit`

**In chat:** `/visual-frontend-audit`

Conducts expert-level visual frontend design audits using design theory, Gestalt principles, colour psychology, typography, and layout systems. Use when given a URL, screenshots, HTML/CSS, or a description to audit; when the user asks for a design audit, visual review, UI audit, or aesthetic assessment of a website or interface.

*Source:* `/Users/elliesmith/.cursor/skills/visual-frontend-audit/SKILL.md`

## `voice-agents`

**In chat:** `/voice-agents`

"Voice agents represent the frontier of AI interaction - humans speaking naturally with AI systems. The challenge isn't just speech recognition and synthesis, it's achieving natural conversation flow with sub-800ms latency while handling interruptions, background noise, and emotional nuance. This skill covers two architectures: speech-to-speech (OpenAI Realtime API, lowest latency, most natural) and pipeline (STT→LLM→TTS, more control, easier to debug). Key insight: latency is the constraint. Hu"

*Source:* `/Users/elliesmith/.cursor/skills/skills/voice-agents/SKILL.md`

## `voice-ai-development`

**In chat:** `/voice-ai-development`

"Expert in building voice AI applications - from real-time voice agents to voice-enabled apps. Covers OpenAI Realtime API, Vapi for voice agents, Deepgram for transcription, ElevenLabs for synthesis, LiveKit for real-time infrastructure, and WebRTC fundamentals. Knows how to build low-latency, production-ready voice experiences. Use when: voice ai, voice agent, speech to text, text to speech, realtime voice."

*Source:* `/Users/elliesmith/.cursor/skills/skills/voice-ai-development/SKILL.md`

## `voice-ai-engine-development`

**In chat:** `/voice-ai-engine-development`

"Build real-time conversational AI voice engines using async worker pipelines, streaming transcription, LLM agents, and TTS synthesis with interrupt handling and multi-provider support"

*Source:* `/Users/elliesmith/.cursor/skills/skills/voice-ai-engine-development/SKILL.md`

## `vr-ar`

**In chat:** `/vr-ar`

VR/AR development principles. Comfort, interaction, performance requirements.

*Source:* `/Users/elliesmith/.cursor/skills/skills/game-development/vr-ar/SKILL.md`

## `vulnerability-scanner`

**In chat:** `/vulnerability-scanner`

Advanced vulnerability analysis principles. OWASP 2025, Supply Chain Security, attack surface mapping, risk prioritization.

*Source:* `/Users/elliesmith/.cursor/skills/skills/vulnerability-scanner/SKILL.md`

## `wcag-audit-patterns`

**In chat:** `/wcag-audit-patterns`

Conduct WCAG 2.2 accessibility audits with automated testing, manual verification, and remediation guidance. Use when auditing websites for accessibility, fixing WCAG violations, or implementing accessible design patterns.

*Source:* `/Users/elliesmith/.cursor/skills/skills/wcag-audit-patterns/SKILL.md`

## `web-artifacts-builder`

**In chat:** `/web-artifacts-builder`

Suite of tools for creating elaborate, multi-component claude.ai HTML artifacts using modern frontend web technologies (React, Tailwind CSS, shadcn/ui). Use for complex artifacts requiring state management, routing, or shadcn/ui components - not for simple single-file HTML/JSX artifacts.

*Source:* `/Users/elliesmith/.cursor/skills/skills/web-artifacts-builder/SKILL.md`

## `web-design-guidelines`

**In chat:** `/web-design-guidelines`

Review UI code for Web Interface Guidelines compliance. Use when asked to "review my UI", "check accessibility", "audit design", "review UX", or "check my site against best practices".

*Source:* `/Users/elliesmith/.cursor/skills/skills/web-design-guidelines/SKILL.md`

## `web-games`

**In chat:** `/web-games`

Web browser game development principles. Framework selection, WebGPU, optimization, PWA.

*Source:* `/Users/elliesmith/.cursor/skills/skills/game-development/web-games/SKILL.md`

## `web-performance-optimization`

**In chat:** `/web-performance-optimization`

"Optimize website and web application performance including loading speed, Core Web Vitals, bundle size, caching strategies, and runtime performance"

*Source:* `/Users/elliesmith/.cursor/skills/skills/web-performance-optimization/SKILL.md`

## `web3-testing`

**In chat:** `/web3-testing`

Test smart contracts comprehensively using Hardhat and Foundry with unit tests, integration tests, and mainnet forking. Use when testing Solidity contracts, setting up blockchain test suites, or validating DeFi protocols.

*Source:* `/Users/elliesmith/.cursor/skills/skills/web3-testing/SKILL.md`

## `webapp-testing`

**In chat:** `/webapp-testing`

Toolkit for interacting with and testing local web applications using Playwright. Supports verifying frontend functionality, debugging UI behavior, capturing browser screenshots, and viewing browser logs.

*Source:* `/Users/elliesmith/.cursor/skills/skills/webapp-testing/SKILL.md`

## `webflow-automation`

**In chat:** `/webflow-automation`

"Automate Webflow CMS collections, site publishing, page management, asset uploads, and ecommerce orders via Rube MCP (Composio). Always search tools first for current schemas."

*Source:* `/Users/elliesmith/.cursor/skills/skills/webflow-automation/SKILL.md`

## `whatsapp-automation`

**In chat:** `/whatsapp-automation`

"Automate WhatsApp Business tasks via Rube MCP (Composio): send messages, manage templates, upload media, and handle contacts. Always search tools first for current schemas."

*Source:* `/Users/elliesmith/.cursor/skills/skills/whatsapp-automation/SKILL.md`

## `wiki-architect`

**In chat:** `/wiki-architect`

Analyzes code repositories and generates hierarchical documentation structures with onboarding guides. Use when the user wants to create a wiki, generate documentation, map a codebase structure, or understand a project's architecture at a high level.

*Source:* `/Users/elliesmith/.cursor/skills/skills/wiki-architect/SKILL.md`

## `wiki-changelog`

**In chat:** `/wiki-changelog`

Analyzes git commit history and generates structured changelogs categorized by change type. Use when the user asks about recent changes, wants a changelog, or needs to understand what changed in the repository.

*Source:* `/Users/elliesmith/.cursor/skills/skills/wiki-changelog/SKILL.md`

## `wiki-onboarding`

**In chat:** `/wiki-onboarding`

Generates two complementary onboarding guides — a Principal-Level architectural deep-dive and a Zero-to-Hero contributor walkthrough. Use when the user wants onboarding documentation for a codebase.

*Source:* `/Users/elliesmith/.cursor/skills/skills/wiki-onboarding/SKILL.md`

## `wiki-page-writer`

**In chat:** `/wiki-page-writer`

Generates rich technical documentation pages with dark-mode Mermaid diagrams, source code citations, and first-principles depth. Use when writing documentation, generating wiki pages, creating technical deep-dives, or documenting specific components or systems.

*Source:* `/Users/elliesmith/.cursor/skills/skills/wiki-page-writer/SKILL.md`

## `wiki-qa`

**In chat:** `/wiki-qa`

Answers questions about a code repository using source file analysis. Use when the user asks a question about how something works, wants to understand a component, or needs help navigating the codebase.

*Source:* `/Users/elliesmith/.cursor/skills/skills/wiki-qa/SKILL.md`

## `wiki-researcher`

**In chat:** `/wiki-researcher`

Conducts multi-turn iterative deep research on specific topics within a codebase with zero tolerance for shallow analysis. Use when the user wants an in-depth investigation, needs to understand how something works across multiple files, or asks for comprehensive analysis of a specific system or pattern.

*Source:* `/Users/elliesmith/.cursor/skills/skills/wiki-researcher/SKILL.md`

## `wiki-vitepress`

**In chat:** `/wiki-vitepress`

Packages generated wiki Markdown into a VitePress static site with dark theme, dark-mode Mermaid diagrams with click-to-zoom, and production build output. Use when the user wants to create a browsable website from generated wiki pages.

*Source:* `/Users/elliesmith/.cursor/skills/skills/wiki-vitepress/SKILL.md`

## `Windows Privilege Escalation`

**In chat:** `/windows-privilege-escalation`

This skill should be used when the user asks to "escalate privileges on Windows," "find Windows privesc vectors," "enumerate Windows for privilege escalation," "exploit Windows misconfigurations," or "perform post-exploitation privilege escalation." It provides comprehensive guidance for discovering and exploiting privilege escalation vulnerabilities in Windows environments.

*Source:* `/Users/elliesmith/.cursor/skills/skills/windows-privilege-escalation/SKILL.md`

## `Wireshark Network Traffic Analysis`

**In chat:** `/wireshark-analysis`

This skill should be used when the user asks to "analyze network traffic with Wireshark", "capture packets for troubleshooting", "filter PCAP files", "follow TCP/UDP streams", "detect network anomalies", "investigate suspicious traffic", or "perform protocol analysis". It provides comprehensive techniques for network packet capture, filtering, and analysis using Wireshark.

*Source:* `/Users/elliesmith/.cursor/skills/skills/wireshark-analysis/SKILL.md`

## `WordPress Penetration Testing`

**In chat:** `/wordpress-penetration-testing`

This skill should be used when the user asks to "pentest WordPress sites", "scan WordPress for vulnerabilities", "enumerate WordPress users, themes, or plugins", "exploit WordPress vulnerabilities", or "use WPScan". It provides comprehensive WordPress security assessment methodologies.

*Source:* `/Users/elliesmith/.cursor/skills/skills/wordpress-penetration-testing/SKILL.md`

## `wordpress-theme-classic-meta`

**In chat:** `/wordpress-theme-classic-meta`

Converts a static or SPA site into a custom WordPress theme with classic editor and editable meta fields (no Gutenberg, no ACF). Uses core add_meta_box, post meta, and optional theme setup to seed pages and defaults. Use when converting a site to WordPress theme, building a WordPress theme with editable content fields, classic editor only, or meta boxes for page content.

*Source:* `/Users/elliesmith/.cursor/skills/wordpress-theme-classic-meta/SKILL.md`

## `workflow-automation`

**In chat:** `/workflow-automation`

"Workflow automation is the infrastructure that makes AI agents reliable. Without durable execution, a network hiccup during a 10-step payment flow means lost money and angry customers. With it, workflows resume exactly where they left off. This skill covers the platforms (n8n, Temporal, Inngest) and patterns (sequential, parallel, orchestrator-worker) that turn brittle scripts into production-grade automation. Key insight: The platforms make different tradeoffs. n8n optimizes for accessibility"

*Source:* `/Users/elliesmith/.cursor/skills/skills/workflow-automation/SKILL.md`

## `workflow-orchestration-patterns`

**In chat:** `/workflow-orchestration-patterns`

Design durable workflows with Temporal for distributed systems. Covers workflow vs activity separation, saga patterns, state management, and determinism constraints. Use when building long-running processes, distributed transactions, or microservice orchestration.

*Source:* `/Users/elliesmith/.cursor/skills/skills/workflow-orchestration-patterns/SKILL.md`

## `workflow-patterns`

**In chat:** `/workflow-patterns`

Use this skill when implementing tasks according to Conductor's TDD workflow, handling phase checkpoints, managing git commits for tasks, or understanding the verification protocol.

*Source:* `/Users/elliesmith/.cursor/skills/skills/workflow-patterns/SKILL.md`

## `wrike-automation`

**In chat:** `/wrike-automation`

"Automate Wrike project management via Rube MCP (Composio): create tasks/folders, manage projects, assign work, and track progress. Always search tools first for current schemas."

*Source:* `/Users/elliesmith/.cursor/skills/skills/wrike-automation/SKILL.md`

## `writing-plans`

**In chat:** `/writing-plans`

Use when you have a spec or requirements for a multi-step task, before touching code

*Source:* `/Users/elliesmith/.cursor/skills/skills/writing-plans/SKILL.md`

## `writing-skills`

**In chat:** `/writing-skills`

Use when creating, updating, or improving agent skills.

*Source:* `/Users/elliesmith/.cursor/skills/skills/writing-skills/SKILL.md`

## `x-article-publisher-skill`

**In chat:** `/x-article-publisher-skill`

"Publish articles to X/Twitter"

*Source:* `/Users/elliesmith/.cursor/skills/skills/x-article-publisher-skill/SKILL.md`

## `xlsx`

**In chat:** `/xlsx-official`

"Comprehensive spreadsheet creation, editing, and analysis with support for formulas, formatting, data analysis, and visualization. When Claude needs to work with spreadsheets (.xlsx, .xlsm, .csv, .tsv, etc) for: (1) Creating new spreadsheets with formulas and formatting, (2) Reading or analyzing data, (3) Modify existing spreadsheets while preserving formulas, (4) Data analysis and visualization in spreadsheets, or (5) Recalculating formulas"

*Source:* `/Users/elliesmith/.cursor/skills/skills/xlsx-official/SKILL.md`

## `youtube-automation`

**In chat:** `/youtube-automation`

"Automate YouTube tasks via Rube MCP (Composio): upload videos, manage playlists, search content, get analytics, and handle comments. Always search tools first for current schemas."

*Source:* `/Users/elliesmith/.cursor/skills/skills/youtube-automation/SKILL.md`

## `youtube-summarizer`

**In chat:** `/youtube-summarizer`

"Extract transcripts from YouTube videos and generate comprehensive, detailed summaries using intelligent analysis frameworks"

*Source:* `/Users/elliesmith/.cursor/skills/skills/youtube-summarizer/SKILL.md`

## `zapier-make-patterns`

**In chat:** `/zapier-make-patterns`

"No-code automation democratizes workflow building. Zapier and Make (formerly Integromat) let non-developers automate business processes without writing code. But no-code doesn't mean no-complexity - these platforms have their own patterns, pitfalls, and breaking points. This skill covers when to use which platform, how to build reliable automations, and when to graduate to code-based solutions. Key insight: Zapier optimizes for simplicity and integrations (7000+ apps), Make optimizes for power "

*Source:* `/Users/elliesmith/.cursor/skills/skills/zapier-make-patterns/SKILL.md`

## `zendesk-automation`

**In chat:** `/zendesk-automation`

"Automate Zendesk tasks via Rube MCP (Composio): tickets, users, organizations, replies. Always search tools first for current schemas."

*Source:* `/Users/elliesmith/.cursor/skills/skills/zendesk-automation/SKILL.md`

## `zoho-crm-automation`

**In chat:** `/zoho-crm-automation`

"Automate Zoho CRM tasks via Rube MCP (Composio): create/update records, search contacts, manage leads, and convert leads. Always search tools first for current schemas."

*Source:* `/Users/elliesmith/.cursor/skills/skills/zoho-crm-automation/SKILL.md`

## `zoom-automation`

**In chat:** `/zoom-automation`

"Automate Zoom meeting creation, management, recordings, webinars, and participant tracking via Rube MCP (Composio). Always search tools first for current schemas."

*Source:* `/Users/elliesmith/.cursor/skills/skills/zoom-automation/SKILL.md`

## `zustand-store-ts`

**In chat:** `/zustand-store-ts`

Create Zustand stores with TypeScript, subscribeWithSelector middleware, and proper state/action separation. Use when building React state management, creating global stores, or implementing reactive state patterns with Zustand.

*Source:* `/Users/elliesmith/.cursor/skills/skills/zustand-store-ts/SKILL.md`
