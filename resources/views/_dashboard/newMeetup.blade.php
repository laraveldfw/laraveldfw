<form name="newMeetupForm" novalidate ng-submit="createNewMeetup(newMeetupForm)">
    <div layout="row" layout-align="center center">
        <h3 class="md-title">
            Create a new Meetup
        </h3>
    </div>
    <div layout="row" layout-margin>
        <md-checkbox ng-model="meetup.online" aria-label="Online Meetup">
            Online Meetup
        </md-checkbox>
        <md-input-container flex>
            <label>Start Time (double click choices)</label>
            <input type="text"
                   mdc-datetime-picker
                   required
                   date="true"
                   time="true"
                   id="startTime"
                   name="startTime"
                   short-time="true"
                   format="MM/DD/YYYY h:mma"
                   ng-model="meetup.start_time" />
            <div ng-messages="newMeetupForm.startTime.$error">
                <div ng-message="required">Start time is required</div>
            </div>
        </md-input-container>
    </div>
    <div layout="row" layout-margin>
        <md-input-container class="md-input-has-placeholder" flex ng-hide="meetup.online">
            <label>Location</label>
            <input type="text"
                   ng-autocomplete
                   ng-required="!meetup.online"
                   id="locationName"
                   name="locationName"
                   details="placeDetails"
                   ng-model="meetup.location_name" />
            <div ng-messages="newMeetupForm.locationName.$error">
                <div ng-message="required">A place is required</div>
            </div>
        </md-input-container>
    </div>
    <div layout="row" layout-margin ng-hide="meetup.online">
        <md-input-container flex>
            <label>Location Address</label>
            <input type="text"
                   ng-required="!meetup.online"
                   name="locationAddress"
                   id="locationAddress"
                   ng-model="meetup.location_address" />
            <div ng-messages="newMeetupForm.locationAddress.$error">
                <div ng-message="required">An address is required</div>
            </div>
        </md-input-container>
    </div>
    <div layout="row" layout-margin ng-hide="meetup.online">
        <md-input-container flex="50">
            <label>Location Phone</label>
            <input type="text"
                   ng-required="!meetup.online"
                   id="locationPhone"
                   name="locationPhone"
                   ng-model="meetup.location_phone" />
            <div ng-messages="newMeetupForm.locationPhone.$error">
                <div ng-message="required">A phone number is required</div>
            </div>
        </md-input-container>
        <md-input-container flex="50">
            <label>Location Url</label>
            <input type="url"
                   ng-required="!meetup.online"
                   id="locationUrl"
                   name="locationUrl"
                   ng-model="meetup.location_url" />
            <div ng-messages="newMeetupForm.locationUrl.$error">
                <div ng-message="required">A location url is required</div>
                <div ng-message="url">Not a valid url</div>
            </div>
        </md-input-container>
    </div>
    <div layout="row" layout-margin>
        <md-input-container flex>
            <label>@{{ meetup.online ? 'Talk' : 'Event Title' }}</label>
            <input type="text"
                   required
                   id="meetupTalk"
                   name="meetupTalk"
                   maxlength="255"
                   ng-model="meetup.talk" />
            <div ng-messages="newMeetupForm.meetupTalk.$error">
                <div ng-message="required">A talk or dinner headline is required</div>
            </div>
        </md-input-container>
    </div>
    <div layout="row" layout-margin>
        <div flex="10" ng-show="meetup.speaker_img && newMeetupForm.speakerImgUrl.$touched && newMeetupForm.speakerImgUrl.$valid">
            <img ng-src="@{{ meetup.speaker_img }}"
                 width="60"
                 height="60" />
        </div>
        <md-input-container flex="30">
            <label>Speaker's Name</label>
            <input type="text"
                   name="speakerName"
                   id="speakerName"
                   ng-model="meetup.speaker" />
        </md-input-container>
        <md-input-container flex="30">
            <label>Speaker's Image Url</label>
            <input type="url"
                   name="speakerImgUrl"
                   id="speakerImgUrl"
                   ng-model="meetup.speaker_img" />
            <div ng-messages="newMeetupForm.speakerImgUrl.$error">
                <div ng-message="url">Not a valid url</div>
            </div>
        </md-input-container>
        <md-input-container flex="30">
            <label>Speaker's Contact Url</label>
            <input type="url"
                   name="speakerUrl"
                   id="speakerUrl"
                   ng-model="meetup.speaker_url" />
            <div ng-messages="newMeetupForm.speakerUrl.$error">
                <div ng-message="url">Not a valid url</div>
            </div>
        </md-input-container>
    </div>
    <div layout="row" layout-margin>
        <md-input-container flex>
            <label>Additional Info</label>
            <input type="text"
                   ng-model="meetup.additional_info" />
        </md-input-container>
    </div>
    <div layout="row" layout-align="center center">
        <md-button class="md-raised md-primary" type="submit" ng-disabled="savingNewMeetup || newMeetupForm.$invalid">
            Save New Meetup
        </md-button>
    </div>
</form>