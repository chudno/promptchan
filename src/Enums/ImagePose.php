<?php

declare(strict_types=1);

namespace Chudno\Promptchan\Enums;

enum ImagePose: string
{
    // Common poses
    case STANDING = 'Standing';
    case SITTING = 'Sitting';
    case LYING_DOWN = 'Lying down';
    case KNEELING = 'Kneeling';
    case WALKING = 'Walking';
    case RUNNING = 'Running';
    case DANCING = 'Dancing';
    case JUMPING = 'Jumping';
    case STRETCHING = 'Stretching';
    case YOGA_POSE = 'Yoga pose';
    case MEDITATION = 'Meditation';
    case READING = 'Reading';
    case WRITING = 'Writing';
    case COOKING = 'Cooking';
    case EATING = 'Eating';
    case DRINKING = 'Drinking';
    case SLEEPING = 'Sleeping';
    case WAKING_UP = 'Waking up';
    case SHOWERING = 'Showering';
    case BATHING = 'Bathing';
    case SWIMMING = 'Swimming';
    case SUNBATHING = 'Sunbathing';
    case EXERCISING = 'Exercising';
    case WEIGHTLIFTING = 'Weightlifting';
    case PLAYING_SPORTS = 'Playing sports';
    case PLAYING_MUSIC = 'Playing music';
    case SINGING = 'Singing';
    case PAINTING = 'Painting';
    case DRAWING = 'Drawing';
    case PHOTOGRAPHY = 'Photography';
    case GARDENING = 'Gardening';
    case CLEANING = 'Cleaning';
    case WORKING = 'Working';
    case STUDYING = 'Studying';
    case TEACHING = 'Teaching';
    case PRESENTING = 'Presenting';
    case SHOPPING = 'Shopping';
    case TRAVELING = 'Traveling';
    case DRIVING = 'Driving';
    case BIKING = 'Biking';
    case HIKING = 'Hiking';
    case CAMPING = 'Camping';
    case FISHING = 'Fishing';
    case HUNTING = 'Hunting';
    case SKIING = 'Skiing';
    case SNOWBOARDING = 'Snowboarding';
    case SURFING = 'Surfing';
    case SAILING = 'Sailing';
    case FLYING = 'Flying';
    case CLIMBING = 'Climbing';
    case RAPPELLING = 'Rappelling';
    case PARACHUTING = 'Parachuting';
    case BUNGEE_JUMPING = 'Bungee jumping';
    case SKYDIVING = 'Skydiving';
    case SCUBA_DIVING = 'Scuba diving';
    case SNORKELING = 'Snorkeling';
    case KAYAKING = 'Kayaking';
    case CANOEING = 'Canoeing';
    case RAFTING = 'Rafting';
    case HORSEBACK_RIDING = 'Horseback riding';
    case MOTORCYCLE_RIDING = 'Motorcycle riding';
    case SKATEBOARDING = 'Skateboarding';
    case ROLLERBLADING = 'Rollerblading';
    case ICE_SKATING = 'Ice skating';
    case FIGURE_SKATING = 'Figure skating';
    case HOCKEY = 'Hockey';
    case FOOTBALL = 'Football';
    case BASKETBALL = 'Basketball';
    case BASEBALL = 'Baseball';
    case TENNIS = 'Tennis';
    case GOLF = 'Golf';
    case VOLLEYBALL = 'Volleyball';
    case SOCCER = 'Soccer';
    case BOXING = 'Boxing';
    case MARTIAL_ARTS = 'Martial arts';
    case WRESTLING = 'Wrestling';
    case FENCING = 'Fencing';
    case ARCHERY = 'Archery';
    case SHOOTING = 'Shooting';
    case BOWLING = 'Bowling';
    case POOL = 'Pool';
    case DARTS = 'Darts';
    case CHESS = 'Chess';
    case CARDS = 'Cards';
    case VIDEO_GAMES = 'Video games';
    case BOARD_GAMES = 'Board games';
    case PUZZLES = 'Puzzles';
    case MAGIC_TRICKS = 'Magic tricks';
    case JUGGLING = 'Juggling';
    case ACROBATICS = 'Acrobatics';
    case GYMNASTICS = 'Gymnastics';
    case CHEERLEADING = 'Cheerleading';
    case BALLET = 'Ballet';
    case BALLROOM_DANCING = 'Ballroom dancing';
    case SALSA_DANCING = 'Salsa dancing';
    case HIP_HOP_DANCING = 'Hip hop dancing';
    case BREAKDANCING = 'Breakdancing';
    case POLE_DANCING = 'Pole dancing';
    case BELLY_DANCING = 'Belly dancing';
    case STRIP_TEASE = 'Strip tease';
    case MODELING = 'Modeling';
    case POSING = 'Posing';
    case FASHION_SHOW = 'Fashion show';
    case RUNWAY_WALKING = 'Runway walking';
    case PHOTO_SHOOT = 'Photo shoot';
    case ACTING = 'Acting';
    case THEATER = 'Theater';
    case OPERA = 'Opera';
    case CONCERT = 'Concert';
    case DJ = 'DJ';
    case PARTY = 'Party';
    case CELEBRATION = 'Celebration';
    case WEDDING = 'Wedding';
    case GRADUATION = 'Graduation';
    case BIRTHDAY = 'Birthday';
    case HOLIDAY = 'Holiday';
    case VACATION = 'Vacation';
    case RELAXING = 'Relaxing';
    case LOUNGING = 'Lounging';
    case RESTING = 'Resting';
    case NAPPING = 'Napping';
    case DREAMING = 'Dreaming';
    case THINKING = 'Thinking';
    case CONTEMPLATING = 'Contemplating';
    case PRAYING = 'Praying';
    case WORSHIPPING = 'Worshipping';
    case CEREMONY = 'Ceremony';
    case RITUAL = 'Ritual';
    case MAGIC = 'Magic';
    case SPELL_CASTING = 'Spell casting';
    case FORTUNE_TELLING = 'Fortune telling';
    case TAROT_READING = 'Tarot reading';
    case CRYSTAL_GAZING = 'Crystal gazing';
    case ASTROLOGY = 'Astrology';
    case ASTRONOMY = 'Astronomy';
    case STARGAZING = 'Stargazing';
    case MOON_GAZING = 'Moon gazing';
    case SUN_GAZING = 'Sun gazing';
    case CLOUD_WATCHING = 'Cloud watching';
    case BIRD_WATCHING = 'Bird watching';
    case ANIMAL_WATCHING = 'Animal watching';
    case NATURE_WATCHING = 'Nature watching';
    case FLOWER_PICKING = 'Flower picking';
    case FRUIT_PICKING = 'Fruit picking';
    case BERRY_PICKING = 'Berry picking';
    case MUSHROOM_PICKING = 'Mushroom picking';
    case HERB_GATHERING = 'Herb gathering';
    case FORAGING = 'Foraging';
    case TREASURE_HUNTING = 'Treasure hunting';
    case METAL_DETECTING = 'Metal detecting';
    case ARCHAEOLOGY = 'Archaeology';
    case EXCAVATION = 'Excavation';
    case EXPLORATION = 'Exploration';
    case ADVENTURE = 'Adventure';
    case QUEST = 'Quest';
    case MISSION = 'Mission';
    case RESCUE = 'Rescue';
    case SURVIVAL = 'Survival';
    case WILDERNESS = 'Wilderness';
    case DESERT = 'Desert';
    case JUNGLE = 'Jungle';
    case FOREST = 'Forest';
    case MOUNTAIN = 'Mountain';
    case BEACH = 'Beach';
    case OCEAN = 'Ocean';
    case LAKE = 'Lake';
    case RIVER = 'River';
    case WATERFALL = 'Waterfall';
    case CAVE = 'Cave';
    case UNDERGROUND = 'Underground';
    case SPACE = 'Space';
    case ALIEN = 'Alien';
    case ROBOT = 'Robot';
    case CYBORG = 'Cyborg';
    case ANDROID = 'Android';
    case FUTURISTIC = 'Futuristic';
    case SCI_FI = 'Sci-fi';
    case FANTASY = 'Fantasy';
    case MEDIEVAL = 'Medieval';
    case ANCIENT = 'Ancient';
    case HISTORICAL = 'Historical';
    case VINTAGE = 'Vintage';
    case RETRO = 'Retro';
    case CLASSIC = 'Classic';
    case MODERN = 'Modern';
    case CONTEMPORARY = 'Contemporary';
    case AVANT_GARDE = 'Avant-garde';
    case ARTISTIC = 'Artistic';
    case CREATIVE = 'Creative';
    case INNOVATIVE = 'Innovative';
    case EXPERIMENTAL = 'Experimental';
    case ABSTRACT = 'Abstract';
    case SURREAL = 'Surreal';
    case DREAMLIKE = 'Dreamlike';
    case ETHEREAL = 'Ethereal';
    case MYSTICAL = 'Mystical';
    case SPIRITUAL = 'Spiritual';
    case DIVINE = 'Divine';
    case ANGELIC = 'Angelic';
    case DEMONIC = 'Demonic';
    case GOTHIC = 'Gothic';
    case DARK = 'Dark';
    case MYSTERIOUS = 'Mysterious';
    case SECRETIVE = 'Secretive';
    case HIDDEN = 'Hidden';
    case INVISIBLE = 'Invisible';
    case TRANSPARENT = 'Transparent';
    case GLOWING = 'Glowing';
    case SHINING = 'Shining';
    case SPARKLING = 'Sparkling';
    case GLITTERING = 'Glittering';
    case RADIANT = 'Radiant';
    case LUMINOUS = 'Luminous';
    case BRILLIANT_MIND = 'Brilliant mind';
    case DAZZLING = 'Dazzling';
    case STUNNING = 'Stunning';
    case BREATHTAKING = 'Breathtaking';
    case MAGNIFICENT = 'Magnificent';
    case MAJESTIC = 'Majestic';
    case REGAL = 'Regal';
    case ROYAL = 'Royal';
    case NOBLE = 'Noble';
    case ELEGANT = 'Elegant';
    case GRACEFUL = 'Graceful';
    case SOPHISTICATED = 'Sophisticated';
    case REFINED = 'Refined';
    case CLASSY = 'Classy';
    case STYLISH = 'Stylish';
    case FASHIONABLE = 'Fashionable';
    case TRENDY = 'Trendy';
    case CHIC = 'Chic';
    case GLAMOROUS = 'Glamorous';
    case LUXURIOUS = 'Luxurious';
    case OPULENT = 'Opulent';
    case LAVISH = 'Lavish';
    case EXTRAVAGANT = 'Extravagant';
    case DECADENT = 'Decadent';
    case INDULGENT = 'Indulgent';
    case SENSUAL = 'Sensual';
    case SEDUCTIVE = 'Seductive';
    case ALLURING = 'Alluring';
    case ENTICING = 'Enticing';
    case TEMPTING = 'Tempting';
    case PROVOCATIVE = 'Provocative';
    case FLIRTATIOUS = 'Flirtatious';
    case PLAYFUL = 'Playful';
    case MISCHIEVOUS = 'Mischievous';
    case NAUGHTY = 'Naughty';
    case WILD = 'Wild';
    case CRAZY = 'Crazy';
    case INSANE = 'Insane';
    case MAD = 'Mad';
    case ANGRY = 'Angry';
    case FURIOUS = 'Furious';
    case RAGE = 'Rage';
    case VIOLENT = 'Violent';
    case AGGRESSIVE = 'Aggressive';
    case FIERCE = 'Fierce';
    case INTIMIDATING = 'Intimidating';
    case THREATENING = 'Threatening';
    case DANGEROUS = 'Dangerous';
    case DEADLY = 'Deadly';
    case LETHAL = 'Lethal';
    case FATAL = 'Fatal';
    case DESTRUCTIVE = 'Destructive';
    case DEVASTATING = 'Devastating';
    case CATASTROPHIC = 'Catastrophic';
    case APOCALYPTIC = 'Apocalyptic';
    case CHAOTIC = 'Chaotic';
    case TURBULENT = 'Turbulent';
    case STORMY = 'Stormy';
    case TEMPESTUOUS = 'Tempestuous';
    case TUMULTUOUS = 'Tumultuous';
    case DRAMATIC = 'Dramatic';
    case INTENSE = 'Intense';
    case PASSIONATE = 'Passionate';
    case EMOTIONAL = 'Emotional';
    case EXPRESSIVE = 'Expressive';
    case ANIMATED = 'Animated';
    case LIVELY = 'Lively';
    case ENERGETIC = 'Energetic';
    case DYNAMIC = 'Dynamic';
    case VIBRANT = 'Vibrant';
    case VIVID = 'Vivid';
    case COLORFUL = 'Colorful';
    case BRIGHT = 'Bright';
    case CHEERFUL = 'Cheerful';
    case HAPPY = 'Happy';
    case JOYFUL = 'Joyful';
    case BLISSFUL = 'Blissful';
    case ECSTATIC = 'Ecstatic';
    case EUPHORIC = 'Euphoric';
    case ELATED = 'Elated';
    case EXCITED = 'Excited';
    case THRILLED = 'Thrilled';
    case EXHILARATED = 'Exhilarated';
    case INVIGORATED = 'Invigorated';
    case REFRESHED = 'Refreshed';
    case REJUVENATED = 'Rejuvenated';
    case REVITALIZED = 'Revitalized';
    case RENEWED = 'Renewed';
    case REBORN = 'Reborn';
    case TRANSFORMED = 'Transformed';
    case METAMORPHOSED = 'Metamorphosed';
    case EVOLVED = 'Evolved';
    case ADVANCED = 'Advanced';
    case PROGRESSIVE = 'Progressive';
    case FORWARD_THINKING = 'Forward-thinking';
    case VISIONARY = 'Visionary';
    case PIONEERING = 'Pioneering';
    case GROUNDBREAKING = 'Groundbreaking';
    case REVOLUTIONARY = 'Revolutionary';
    case RADICAL = 'Radical';
    case EXTREME = 'Extreme';
    case ULTIMATE = 'Ultimate';
    case SUPREME = 'Supreme';
    case PERFECT = 'Perfect';
    case FLAWLESS = 'Flawless';
    case IMPECCABLE = 'Impeccable';
    case PRISTINE = 'Pristine';
    case PURE = 'Pure';
    case INNOCENT = 'Innocent';
    case NAIVE = 'Naive';
    case CHILDLIKE = 'Childlike';
    case YOUTHFUL = 'Youthful';
    case MATURE = 'Mature';
    case WISE = 'Wise';
    case EXPERIENCED = 'Experienced';
    case KNOWLEDGEABLE = 'Knowledgeable';
    case INTELLIGENT = 'Intelligent';
    case BRILLIANT = 'Brilliant';
    case GENIUS = 'Genius';
    case MASTERMIND = 'Mastermind';
    case EXPERT = 'Expert';
    case PROFESSIONAL = 'Professional';
    case SKILLED = 'Skilled';
    case TALENTED = 'Talented';
    case GIFTED = 'Gifted';
    case EXCEPTIONAL = 'Exceptional';
    case EXTRAORDINARY = 'Extraordinary';
    case REMARKABLE = 'Remarkable';
    case OUTSTANDING = 'Outstanding';
    case SUPERB = 'Superb';
    case EXCELLENT = 'Excellent';
    case FANTASTIC = 'Fantastic';
    case AMAZING = 'Amazing';
    case INCREDIBLE = 'Incredible';
    case UNBELIEVABLE = 'Unbelievable';
    case MIRACULOUS = 'Miraculous';
    case MAGICAL = 'Magical';
    case ENCHANTING = 'Enchanting';
    case CAPTIVATING = 'Captivating';
    case MESMERIZING = 'Mesmerizing';
    case HYPNOTIC = 'Hypnotic';
    case SPELLBINDING = 'Spellbinding';
    case BEWITCHING = 'Bewitching';
    case CHARMING = 'Charming';
    case DELIGHTFUL = 'Delightful';
    case LOVELY = 'Lovely';
    case BEAUTIFUL = 'Beautiful';
    case GORGEOUS = 'Gorgeous';
    case STUNNING_BEAUTY = 'Stunning beauty';
    case BREATHTAKING_BEAUTY = 'Breathtaking beauty';
    case DIVINE_BEAUTY = 'Divine beauty';
    case HEAVENLY_BEAUTY = 'Heavenly beauty';
    case ANGELIC_BEAUTY = 'Angelic beauty';
    case ETHEREAL_BEAUTY = 'Ethereal beauty';
    case OTHERWORLDLY_BEAUTY = 'Otherworldly beauty';
    case SUPERNATURAL_BEAUTY = 'Supernatural beauty';
    case MYSTICAL_BEAUTY = 'Mystical beauty';
    case ENCHANTED_BEAUTY = 'Enchanted beauty';
    case MAGICAL_BEAUTY = 'Magical beauty';
    case FAIRY_TALE_BEAUTY = 'Fairy tale beauty';
    case STORYBOOK_BEAUTY = 'Storybook beauty';
    case CINEMATIC_BEAUTY = 'Cinematic beauty';
    case PHOTOGENIC_BEAUTY = 'Photogenic beauty';
    case MODEL_BEAUTY = 'Model beauty';
    case SUPERMODEL_BEAUTY = 'Supermodel beauty';
    case GODDESS_BEAUTY = 'Goddess beauty';
    case QUEEN_BEAUTY = 'Queen beauty';
    case PRINCESS_BEAUTY = 'Princess beauty';
    case ROYAL_BEAUTY = 'Royal beauty';
    case NOBLE_BEAUTY = 'Noble beauty';
    case ARISTOCRATIC_BEAUTY = 'Aristocratic beauty';
    case ELEGANT_BEAUTY = 'Elegant beauty';
    case SOPHISTICATED_BEAUTY = 'Sophisticated beauty';
    case REFINED_BEAUTY = 'Refined beauty';
    case CLASSY_BEAUTY = 'Classy beauty';
    case STYLISH_BEAUTY = 'Stylish beauty';
    case FASHIONABLE_BEAUTY = 'Fashionable beauty';
    case TRENDY_BEAUTY = 'Trendy beauty';
    case CHIC_BEAUTY = 'Chic beauty';
    case GLAMOROUS_BEAUTY = 'Glamorous beauty';
    case LUXURIOUS_BEAUTY = 'Luxurious beauty';
    case OPULENT_BEAUTY = 'Opulent beauty';
    case LAVISH_BEAUTY = 'Lavish beauty';
    case EXTRAVAGANT_BEAUTY = 'Extravagant beauty';
    case DECADENT_BEAUTY = 'Decadent beauty';
    case INDULGENT_BEAUTY = 'Indulgent beauty';
    case SENSUAL_BEAUTY = 'Sensual beauty';
    case SEDUCTIVE_BEAUTY = 'Seductive beauty';
    case ALLURING_BEAUTY = 'Alluring beauty';
    case ENTICING_BEAUTY = 'Enticing beauty';
    case TEMPTING_BEAUTY = 'Tempting beauty';
    case PROVOCATIVE_BEAUTY = 'Provocative beauty';
    case FLIRTATIOUS_BEAUTY = 'Flirtatious beauty';
    case PLAYFUL_BEAUTY = 'Playful beauty';
    case MISCHIEVOUS_BEAUTY = 'Mischievous beauty';
    case NAUGHTY_BEAUTY = 'Naughty beauty';
    case WILD_BEAUTY = 'Wild beauty';
    case UNTAMED_BEAUTY = 'Untamed beauty';
    case FIERCE_BEAUTY = 'Fierce beauty';
    case BOLD_BEAUTY = 'Bold beauty';
    case CONFIDENT_BEAUTY = 'Confident beauty';
    case STRONG_BEAUTY = 'Strong beauty';
    case POWERFUL_BEAUTY = 'Powerful beauty';
    case DOMINANT_BEAUTY = 'Dominant beauty';
    case COMMANDING_BEAUTY = 'Commanding beauty';
    case AUTHORITATIVE_BEAUTY = 'Authoritative beauty';
    case LEADERSHIP_BEAUTY = 'Leadership beauty';
    case EXECUTIVE_BEAUTY = 'Executive beauty';
    case BUSINESS_BEAUTY = 'Business beauty';
    case PROFESSIONAL_BEAUTY = 'Professional beauty';
    case CORPORATE_BEAUTY = 'Corporate beauty';
    case OFFICE_BEAUTY = 'Office beauty';
    case WORKPLACE_BEAUTY = 'Workplace beauty';
    case CAREER_BEAUTY = 'Career beauty';
    case SUCCESS_BEAUTY = 'Success beauty';
    case ACHIEVEMENT_BEAUTY = 'Achievement beauty';
    case VICTORY_BEAUTY = 'Victory beauty';
    case TRIUMPH_BEAUTY = 'Triumph beauty';
    case WINNING_BEAUTY = 'Winning beauty';
    case CHAMPION_BEAUTY = 'Champion beauty';
    case HERO_BEAUTY = 'Hero beauty';
    case WARRIOR_BEAUTY = 'Warrior beauty';
    case FIGHTER_BEAUTY = 'Fighter beauty';
    case SURVIVOR_BEAUTY = 'Survivor beauty';
    case RESILIENT_BEAUTY = 'Resilient beauty';
    case ENDURING_BEAUTY = 'Enduring beauty';
    case LASTING_BEAUTY = 'Lasting beauty';
    case TIMELESS_BEAUTY = 'Timeless beauty';
    case ETERNAL_BEAUTY = 'Eternal beauty';
    case IMMORTAL_BEAUTY = 'Immortal beauty';
    case LEGENDARY_BEAUTY = 'Legendary beauty';
    case MYTHICAL_BEAUTY = 'Mythical beauty';
    case EPIC_BEAUTY = 'Epic beauty';
    case HEROIC_BEAUTY = 'Heroic beauty';
    case NOBLE_SPIRIT = 'Noble spirit';
    case PURE_SPIRIT = 'Pure spirit';
    case GENTLE_SPIRIT = 'Gentle spirit';
    case KIND_SPIRIT = 'Kind spirit';
    case LOVING_SPIRIT = 'Loving spirit';
    case CARING_SPIRIT = 'Caring spirit';
    case NURTURING_SPIRIT = 'Nurturing spirit';
    case PROTECTIVE_SPIRIT = 'Protective spirit';
    case GUARDIAN_SPIRIT = 'Guardian spirit';
    case ANGEL_SPIRIT = 'Angel spirit';
    case DIVINE_SPIRIT = 'Divine spirit';
    case HOLY_SPIRIT = 'Holy spirit';
    case SACRED_SPIRIT = 'Sacred spirit';
    case BLESSED_SPIRIT = 'Blessed spirit';
    case ENLIGHTENED_SPIRIT = 'Enlightened spirit';
    case AWAKENED_SPIRIT = 'Awakened spirit';
    case CONSCIOUS_SPIRIT = 'Conscious spirit';
    case AWARE_SPIRIT = 'Aware spirit';
    case MINDFUL_SPIRIT = 'Mindful spirit';
    case PRESENT_SPIRIT = 'Present spirit';
    case CENTERED_SPIRIT = 'Centered spirit';
    case BALANCED_SPIRIT = 'Balanced spirit';
    case HARMONIOUS_SPIRIT = 'Harmonious spirit';
    case PEACEFUL_SPIRIT = 'Peaceful spirit';
    case SERENE_SPIRIT = 'Serene spirit';
    case TRANQUIL_SPIRIT = 'Tranquil spirit';
    case CALM_SPIRIT = 'Calm spirit';
    case RELAXED_SPIRIT = 'Relaxed spirit';
    case CONTENT_SPIRIT = 'Content spirit';
    case SATISFIED_SPIRIT = 'Satisfied spirit';
    case FULFILLED_SPIRIT = 'Fulfilled spirit';
    case COMPLETE_SPIRIT = 'Complete spirit';
    case WHOLE_SPIRIT = 'Whole spirit';
    case INTEGRATED_SPIRIT = 'Integrated spirit';
    case UNIFIED_SPIRIT = 'Unified spirit';
    case CONNECTED_SPIRIT = 'Connected spirit';
    case LINKED_SPIRIT = 'Linked spirit';
    case BONDED_SPIRIT = 'Bonded spirit';
    case JOINED_SPIRIT = 'Joined spirit';
    case MERGED_SPIRIT = 'Merged spirit';
    case FUSED_SPIRIT = 'Fused spirit';
    case BLENDED_SPIRIT = 'Blended spirit';
    case COMBINED_SPIRIT = 'Combined spirit';
    case UNITED_SPIRIT = 'United spirit';
    case TOGETHER_SPIRIT = 'Together spirit';
    case PARTNERSHIP_SPIRIT = 'Partnership spirit';
    case TEAMWORK_SPIRIT = 'Teamwork spirit';
    case COLLABORATION_SPIRIT = 'Collaboration spirit';
    case COOPERATION_SPIRIT = 'Cooperation spirit';
    case ALLIANCE_SPIRIT = 'Alliance spirit';
    case FRIENDSHIP_SPIRIT = 'Friendship spirit';
    case COMPANIONSHIP_SPIRIT = 'Companionship spirit';
    case FELLOWSHIP_SPIRIT = 'Fellowship spirit';
    case BROTHERHOOD_SPIRIT = 'Brotherhood spirit';
    case SISTERHOOD_SPIRIT = 'Sisterhood spirit';
    case FAMILY_SPIRIT = 'Family spirit';
    case COMMUNITY_SPIRIT = 'Community spirit';
    case SOCIAL_SPIRIT = 'Social spirit';
    case CULTURAL_SPIRIT = 'Cultural spirit';
    case TRADITIONAL_SPIRIT = 'Traditional spirit';
    case HERITAGE_SPIRIT = 'Heritage spirit';
    case ANCESTRAL_SPIRIT = 'Ancestral spirit';
    case ANCIENT_SPIRIT = 'Ancient spirit';
    case PRIMORDIAL_SPIRIT = 'Primordial spirit';
    case ORIGINAL_SPIRIT = 'Original spirit';
    case FIRST_SPIRIT = 'First spirit';
    case BEGINNING_SPIRIT = 'Beginning spirit';
    case GENESIS_SPIRIT = 'Genesis spirit';
    case CREATION_SPIRIT = 'Creation spirit';
    case BIRTH_SPIRIT = 'Birth spirit';
    case LIFE_SPIRIT = 'Life spirit';
    case LIVING_SPIRIT = 'Living spirit';
    case VITAL_SPIRIT = 'Vital spirit';
    case ENERGY_SPIRIT = 'Energy spirit';
    case POWER_SPIRIT = 'Power spirit';
    case FORCE_SPIRIT = 'Force spirit';
    case STRENGTH_SPIRIT = 'Strength spirit';
    case MIGHT_SPIRIT = 'Might spirit';
    case POTENCY_SPIRIT = 'Potency spirit';
    case INTENSITY_SPIRIT = 'Intensity spirit';
    case PASSION_SPIRIT = 'Passion spirit';
    case FIRE_SPIRIT = 'Fire spirit';
    case FLAME_SPIRIT = 'Flame spirit';
    case BURNING_SPIRIT = 'Burning spirit';
    case BLAZING_SPIRIT = 'Blazing spirit';
    case GLOWING_SPIRIT = 'Glowing spirit';
    case RADIANT_SPIRIT = 'Radiant spirit';
    case SHINING_SPIRIT = 'Shining spirit';
    case BRILLIANT_SPIRIT = 'Brilliant spirit';
    case LUMINOUS_SPIRIT = 'Luminous spirit';
    case BRIGHT_SPIRIT = 'Bright spirit';
    case LIGHT_SPIRIT = 'Light spirit';
    case ILLUMINATED_SPIRIT = 'Illuminated spirit';
    case ENLIGHTENED_BEING = 'Enlightened being';
    case AWAKENED_BEING = 'Awakened being';
    case CONSCIOUS_BEING = 'Conscious being';
    case AWARE_BEING = 'Aware being';
    case MINDFUL_BEING = 'Mindful being';
    case PRESENT_BEING = 'Present being';
    case CENTERED_BEING = 'Centered being';
    case BALANCED_BEING = 'Balanced being';
    case HARMONIOUS_BEING = 'Harmonious being';
    case PEACEFUL_BEING = 'Peaceful being';
    case SERENE_BEING = 'Serene being';
    case TRANQUIL_BEING = 'Tranquil being';
    case CALM_BEING = 'Calm being';
    case RELAXED_BEING = 'Relaxed being';
    case CONTENT_BEING = 'Content being';
    case SATISFIED_BEING = 'Satisfied being';
    case FULFILLED_BEING = 'Fulfilled being';
    case COMPLETE_BEING = 'Complete being';
    case WHOLE_BEING = 'Whole being';
    case INTEGRATED_BEING = 'Integrated being';
    case UNIFIED_BEING = 'Unified being';
    case CONNECTED_BEING = 'Connected being';
    case LINKED_BEING = 'Linked being';
    case BONDED_BEING = 'Bonded being';
    case JOINED_BEING = 'Joined being';
    case MERGED_BEING = 'Merged being';
    case FUSED_BEING = 'Fused being';
    case BLENDED_BEING = 'Blended being';
    case COMBINED_BEING = 'Combined being';
    case UNITED_BEING = 'United being';
    case TOGETHER_BEING = 'Together being';
    case PARTNERSHIP_BEING = 'Partnership being';
    case TEAMWORK_BEING = 'Teamwork being';
    case COLLABORATION_BEING = 'Collaboration being';
    case COOPERATION_BEING = 'Cooperation being';
    case ALLIANCE_BEING = 'Alliance being';
    case FRIENDSHIP_BEING = 'Friendship being';
    case COMPANIONSHIP_BEING = 'Companionship being';
    case FELLOWSHIP_BEING = 'Fellowship being';
    case BROTHERHOOD_BEING = 'Brotherhood being';
    case SISTERHOOD_BEING = 'Sisterhood being';
    case FAMILY_BEING = 'Family being';
    case COMMUNITY_BEING = 'Community being';
    case SOCIAL_BEING = 'Social being';
    case CULTURAL_BEING = 'Cultural being';
    case TRADITIONAL_BEING = 'Traditional being';
    case HERITAGE_BEING = 'Heritage being';
    case ANCESTRAL_BEING = 'Ancestral being';
    case ANCIENT_BEING = 'Ancient being';
    case PRIMORDIAL_BEING = 'Primordial being';
    case ORIGINAL_BEING = 'Original being';
    case FIRST_BEING = 'First being';
    case BEGINNING_BEING = 'Beginning being';
    case GENESIS_BEING = 'Genesis being';
    case CREATION_BEING = 'Creation being';
    case BIRTH_BEING = 'Birth being';
    case LIFE_BEING = 'Life being';
    case LIVING_BEING = 'Living being';
    case VITAL_BEING = 'Vital being';
    case ENERGY_BEING = 'Energy being';
    case POWER_BEING = 'Power being';
    case FORCE_BEING = 'Force being';
    case STRENGTH_BEING = 'Strength being';
    case MIGHT_BEING = 'Might being';
    case POTENCY_BEING = 'Potency being';
    case INTENSITY_BEING = 'Intensity being';
    case PASSION_BEING = 'Passion being';
    case FIRE_BEING = 'Fire being';
    case FLAME_BEING = 'Flame being';
    case BURNING_BEING = 'Burning being';
    case BLAZING_BEING = 'Blazing being';
    case GLOWING_BEING = 'Glowing being';
    case RADIANT_BEING = 'Radiant being';
    case SHINING_BEING = 'Shining being';
    case BRILLIANT_BEING = 'Brilliant being';
    case LUMINOUS_BEING = 'Luminous being';
    case BRIGHT_BEING = 'Bright being';
    case LIGHT_BEING = 'Light being';
    case ILLUMINATED_BEING = 'Illuminated being';

    public function getLabel(): string
    {
        return $this->value;
    }

    public function getCategory(): string
    {
        return match ($this) {
            self::STANDING, self::SITTING, self::LYING_DOWN, self::KNEELING => 'Basic Poses',
            self::WALKING, self::RUNNING, self::DANCING, self::JUMPING => 'Movement',
            self::YOGA_POSE, self::MEDITATION, self::STRETCHING => 'Wellness',
            self::READING, self::WRITING, self::STUDYING => 'Intellectual',
            self::COOKING, self::EATING, self::DRINKING => 'Daily Life',
            self::SWIMMING, self::SUNBATHING, self::EXERCISING => 'Fitness',
            self::PLAYING_SPORTS, self::FOOTBALL, self::BASKETBALL => 'Sports',
            self::MODELING, self::POSING, self::FASHION_SHOW => 'Fashion',
            self::ACTING, self::THEATER, self::SINGING => 'Performance',
            default => 'Other',
        };
    }

    public function isNSFW(): bool
    {
        return match ($this) {
            self::STRIP_TEASE, self::POLE_DANCING, self::SEDUCTIVE, self::PROVOCATIVE => true,
            default => false,
        };
    }
}
