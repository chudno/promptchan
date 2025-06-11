# Chat Interaction Example

This example demonstrates how to use the AI chat functionality with character roleplay using the Promptchan SDK.

## Basic Chat

```php
<?php

use Chudno\Promptchan\PromptchanClient;
use Chudno\Promptchan\DataTransferObjects\ChatRequest;

// Initialize the client
$client = new PromptchanClient('your-api-key-here');

// Simple chat without character
$request = new ChatRequest(
    message: 'Hello! How are you today?',
    isRoleplay: false
);

$response = $client->chat()->sendMessage($request);

echo "Reply: {$response->reply}\n";
echo "Character: {$response->character}\n";
```

## Character Creation and Roleplay

```php
use Chudno\Promptchan\DataTransferObjects\CharacterData;

// Create a custom character
$character = new CharacterData(
    name: 'Luna',
    personality: 'Friendly, intelligent, and curious. Loves to learn new things and help others.',
    scenario: 'You are chatting with Luna, a helpful AI assistant who enjoys meaningful conversations.',
    sexuality: 'heterosexual',
    openness: 3,
    emotions: 4,
    age: 25,
    gender: 'female'
);

// Chat with the character
$request = new ChatRequest(
    message: 'Hi Luna! Can you tell me about yourself?',
    characterData: $character,
    isRoleplay: true,
    userName: 'Alex'
);

$response = $client->chat()->sendMessage($request);
echo "Luna: {$response->reply}\n";
```

## Chat with Conversation History

```php
use Chudno\Promptchan\DataTransferObjects\ChatMessage;

// Build conversation history
$chatHistory = [
    new ChatMessage(
        role: 'user',
        content: 'What is your favorite hobby?',
        sendDate: new \DateTimeImmutable('-5 minutes')
    ),
    new ChatMessage(
        role: 'assistant',
        content: 'I love reading books and learning about new technologies!',
        sendDate: new \DateTimeImmutable('-4 minutes')
    ),
    new ChatMessage(
        role: 'user',
        content: 'That sounds interesting! What kind of books do you like?',
        sendDate: new \DateTimeImmutable('-3 minutes')
    ),
];

// Continue the conversation
$request = new ChatRequest(
    message: 'Can you recommend a good book for a beginner in programming?',
    characterData: $character,
    chatHistory: $chatHistory,
    isRoleplay: true,
    userName: 'Alex'
);

$response = $client->chat()->sendMessage($request);
echo "Luna: {$response->reply}\n";
```

## Advanced Character Examples

### Mysterious Character

```php
$mysteriousCharacter = new CharacterData(
    name: 'Sophia',
    personality: 'Mysterious, witty, and philosophical. Enjoys deep conversations about life and the universe.',
    scenario: 'You meet Sophia in a cozy coffee shop on a rainy evening. She seems to know more than she lets on.',
    sexuality: 'bisexual',
    openness: 5,
    emotions: 5,
    age: 30,
    gender: 'female'
);

$request = new ChatRequest(
    message: 'This rain is quite peaceful, isn\'t it? What do you think about when you listen to the rain?',
    characterData: $mysteriousCharacter,
    isRoleplay: true,
    userName: 'Traveler'
);

$response = $client->chat()->sendMessage($request);
```

### Energetic Character

```php
$energeticCharacter = new CharacterData(
    name: 'Zoe',
    personality: 'Bubbly, energetic, and optimistic. Always sees the bright side of things.',
    scenario: 'You\'re at a fitness class where Zoe is the enthusiastic instructor.',
    sexuality: 'heterosexual',
    openness: 4,
    emotions: 5,
    age: 22,
    gender: 'female'
);
```

## Character Parameters Explained

### Personality Traits
- **openness** (1-5): How open the character is to new experiences
- **emotions** (1-5): How emotionally expressive the character is
- **age** (18+): Character's apparent age

### Sexuality Options
- `'heterosexual'`
- `'homosexual'`
- `'bisexual'`

### Gender Options
- `'female'`
- `'male'`
- `'non-binary'`

## Message Roles

When building chat history, use these roles:
- `'user'` - Messages from the human user
- `'assistant'` - Messages from the AI character
- `'system'` - System messages (optional)

## Complete Conversation Example

```php
try {
    // Create character
    $character = new CharacterData(
        name: 'Emma',
        personality: 'Creative, artistic, and passionate about photography.',
        scenario: 'You meet Emma at an art gallery opening. She\'s a professional photographer.',
        age: 27
    );
    
    // Start conversation
    $messages = [];
    
    // First message
    $request1 = new ChatRequest(
        message: 'Hi! I love this photography exhibition. Are you an artist too?',
        characterData: $character,
        isRoleplay: true,
        userName: 'Visitor'
    );
    
    $response1 = $client->chat()->sendMessage($request1);
    echo "You: {$request1->message}\n";
    echo "Emma: {$response1->reply}\n\n";
    
    // Build history for next message
    $messages[] = new ChatMessage('user', $request1->message);
    $messages[] = new ChatMessage('assistant', $response1->reply);
    
    // Continue conversation
    $request2 = new ChatRequest(
        message: 'What type of photography do you specialize in?',
        characterData: $character,
        chatHistory: $messages,
        isRoleplay: true,
        userName: 'Visitor'
    );
    
    $response2 = $client->chat()->sendMessage($request2);
    echo "You: {$request2->message}\n";
    echo "Emma: {$response2->reply}\n";
    
} catch (\Exception $e) {
    echo "Error: {$e->getMessage()}\n";
}
```

## Response Structure

The `ChatResponse` contains:
- `reply` - The character's response message
- `character` - Character information/name

## Tips for Better Conversations

1. **Create detailed personalities**: Be specific about traits and background
2. **Set engaging scenarios**: Give context for the interaction
3. **Use conversation history**: Maintain context across messages
4. **Adjust openness/emotions**: Higher values = more expressive responses
5. **Be consistent with character**: Keep personality traits in mind
6. **Use descriptive prompts**: Paint a scene for better immersion

## Error Handling

```php
try {
    $response = $client->chat()->sendMessage($request);
    echo "Success: {$response->reply}\n";
} catch (\Exception $e) {
    echo "Error: {$e->getMessage()}\n";
    echo "Status Code: {$client->getLastStatusCode()}\n";
}
```