// services/WordPressAPI.js
export default class WordPressAPI {
    constructor() {
        this.config = useRuntimeConfig();
        this.url = this.config.public.wordpressUrl;
    }

    async fetchPosts() {
        console.log('Starting WordPress fetch with URL:', this.url);
        
        const response = await fetch(this.url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                query: `
                 query AllPosts {
                   posts(first: 100) {
                     nodes {
                       title
                       date
                       excerpt
                       uri
                       id
                     }
                   }
                 }`
            }),
        });

        const result = await response.json();

        if (!result || !result.data || !result.data.posts || !result.data.posts.nodes) {
            console.error('Invalid WordPress response structure:', result);
            return [];
        }

        return result.data.posts.nodes.map(node => ({
            title: node.title,
            date: node.date,
            excerpt: node.excerpt,
            uri: node.uri,
            id: node.id
        }));
    }
}